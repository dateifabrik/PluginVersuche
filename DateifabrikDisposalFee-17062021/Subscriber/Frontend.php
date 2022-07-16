<?php

namespace DateifabrikDisposalFee\Subscriber;

use Enlight\Event\SubscriberInterface;
use Shopware\Models\Shop\Shop;

class Frontend implements SubscriberInterface
{

    public static function getSubscribedEvents()
    {
        return [
            'Enlight_Controller_Action_PreDispatch_Frontend_Checkout' => 'onBeforeCheckout',
            'Shopware_Modules_Basket_UpdateCartItems_Updated' => 'onAfterUpdate',
            'Enlight_Controller_Action_PostDispatchSecure_Frontend_Checkout' => 'onAfterCheckout',
            'Shopware_Modules_Basket_DeleteArticle_Start' => 'onDelete',
            'Shopware_Modules_Order_SaveOrder_OrderCreated' => 'onSaveOrder',
        ];
    }


    public function onAfterUpdate(\Enlight_Event_EventArgs $args)
    {
        // wird nach jeder änderung des basket ausgelöst
        // gibt u.a. die neue komplettanzahl des artikels und weitere (geänderte) daten des artikels zurück
        $basketData = Shopware()->Modules()->Basket()->sGetBasketData();

        // materialien und faktor
        $materials = array(
            'plastik' => 0.0002,
            'alu' => 0.0003
        );

        // Daten vorbereiten für Berechnung
        foreach($basketData['content'] as $article){
            $basketArticleData[] =  array(
                'quantity' => $article['quantity'],
                'purchaseunit' => $article['purchaseunit'],
                'weight' => $article['additional_details']['weight'],
                'material' => $article['additional_details']['attributes']['core']['p24_weight']
            );
        }

        /* GESAMTKOSTEN BERECHNEN */
        $totalFee = 0;
        foreach($basketArticleData as $data){
            $singleFee = $data['quantity'] * $data['purchaseunit'] * $data['weight'];
            foreach($materials as $materialKey => $materialValue){
                if($data['material'] == $materialKey){
                    $m[$materialKey][] = $singleFee;
                    $totalFee = $totalFee + $singleFee * $materialValue;
                }
            }
        }
//        echo "<pre>";
//        print_r($m);
//        echo "</pre>";
//        echo "<pre>";
//        print_r("PLASTIK: ". array_sum($m['plastik']));
//        echo "</pre>";
//        echo "<pre>";
//        print_r("ALU: ". array_sum($m['alu']));
//        echo "</pre>";

        $sessionId = Shopware()->Session()->get('sessionId');
        $connection = Shopware()->Container()->get('dbal_connection');

        $materialsForDb = array(
            'sessionID' => $sessionId,
            'alu' => array_sum($m['alu']),
            'plastik' => array_sum($m['plastik'])

        );
        //print_r($materialsForDb);
        //die();

        // gesamtpreis am button ausgeben
        Shopware()->Session()->offsetSet('totalFee', number_format($totalFee, 2, ',', ''));
        Shopware()->Session()->offsetSet('materialsForDb', $materialsForDb);


        // preis der entsorgungskosten im basket aktualisieren
        $builder = $connection->createQueryBuilder();
        $builder
            ->update('s_order_basket', 'sob')
            ->set('sob.price', ':newPrice')
            ->set('sob.netprice', ':newNetPrice')
            ->where('sob.sessionID = :sessionID')
            ->andWhere('sob.ordernumber = :ordernumber')
            ->andWhere('sob.modus = :modus')
            ->setParameter('newPrice', $totalFee)
            ->setParameter('newNetPrice', $totalFee - $totalFee * 19 / 100)
            ->setParameter('sessionID', $sessionId)
            ->setParameter('ordernumber', 'VerpackG')
            ->setParameter('modus', 0);

        $builder->execute();

    }


    // TODO:
    // gewichte der materialien und sessionID ermitteln und für speicherung vorbereiten bzw. in session schreiben
    // gewichte der materialien und sessionID aus session holen und bei saveOrder() in db speichern
    // VerpackG immer als letztes, wenn im basket


    public function onBeforeCheckout(\Enlight_Event_EventArgs $args)
    {

        $subject = $args->getSubject();
        $view = $subject->View();

        $state = $subject->get('session')->offsetGet('state');
        $view->assign('state', $state);
        $add = $subject->get('session')->offsetGet('add');

        // button wurde geklickt
        if(!empty($state) && !empty($add)){
            // VerpackG in Basket
            Shopware()->Modules()->Basket()->sAddArticle('VerpackG', '1');
            // add wieder aus session entfernen
            $subject->get('session')->offsetUnset('add');
        }

    }



    public function onAfterCheckout(\Enlight_Event_EventArgs $args)
    {

        /** @var \Shopware_Controllers_Frontend_Checkout $subject */
        $subject = $args->getSubject();
        $view = $subject->View();

        $disposalFee = $subject->get('session')->offsetGet('totalFee');
        $view->assign('disposalFee', $disposalFee);

        $materialsForDb = $subject->get('session')->offsetGet('materialsForDb');
        $view->assign('materialsForDb', $materialsForDb);

    }



    public function onDelete(\Enlight_Event_EventArgs $args)
    {

        $basket = Shopware()->Modules()->Basket()->sGetBasket();
        $idToDelete = $args->get('id');
        foreach($basket['content'] as $article) {
            // wenn die id genau der id von VerpackG in s_order_basket entspricht
            if ($article['ordernumber'] == 'VerpackG'){
                $verpackId = $article['id'];
                // VerpackG soll gelöscht werden? Dann state aus session löschen
                if ($idToDelete == $verpackId) {
                    Shopware()->Session()->offsetUnset('state');
                }
                // letzter Artikel wird gelöscht? dann wird VerpackG nicht mehr benötigt und kann auch gelöscht werden
                if(count($basket['content']) == 2 && $idToDelete != $verpackId){
                    Shopware()->Session()->offsetUnset('state');
                    Shopware()->Modules()->Basket()->sDeleteArticle($verpackId);
                }
            }
        }

    }

    public function onSaveOrder(\Enlight_Event_EventArgs $args)
    {
        $dataForDb = Shopware()->Session()->get('materialsForDb');
        $connection = Shopware()->Container()->get('dbal_connection');

        $builder = $connection->createQueryBuilder();
        $builder
            ->insert('dateifabrik_disposal_fee')
            ->values(
                array(
                    'sessionID' => '?',
                    'alu' => '?',
                    'plastik' => '?'
                )
            )
            ->setParameter(0, $dataForDb['sessionID'])
            ->setParameter(1, $dataForDb['alu'])
            ->setParameter(2, $dataForDb['plastik']);

            $builder->execute();


    }


}