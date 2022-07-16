<?php

namespace DateifabrikVerpackLizenz\Subscribers;

use Enlight\Event\SubscriberInterface;

class FrontendCheckoutMaterialToBasket implements SubscriberInterface
{


    public static function getSubscribedEvents()
    {
        return [
            'Enlight_Controller_Action_PreDispatch_Frontend_Checkout' => 'onCheckout',
        ];
    }




    public function onCheckout(\Enlight_Event_EventArgs $args)
    {
        /** @var \Shopware_Controllers_Frontend_Checkout $subject */
        $subject = $args->getSubject();
        $view = $subject->View();

        $sOrderVariables = $subject->get('session')->offsetGet('sOrderVariables');

        foreach($sOrderVariables['sBasket']['content'] as $article){

            $basketArticleData[] =  array(
//                'ordernumber' => $article['ordernumber'],
//                'articlename' => $article['articlename'],
//                'articleID' => $article['articleID'],
                'quantity' => $article['quantity'], // value für berechnung
                'purchaseunit' => $article['purchaseunit'],  // value für berechnung
//                'price' => $article['price'],
                'weight' => $article['additional_details']['weight'],  // value für berechnung
                'p24_weight' => $article['additional_details']['attributes']['core']['p24_weight']  // value für berechnung
            );
        }

        /* GESAMTKOSTEN BERECHNEN */

        // TODO: Daten besser aus einer Config im Backend laden
        $materialien = array(
            'plastik' => 2.0,
            'alu' => 3.0
        );
        $gesamt = 0;
        foreach($basketArticleData as $b){
            $zwischenpreis = $b['quantity'] * $b['purchaseunit'] * $b['weight'];
            foreach($materialien as $m => $val){
                if($b['p24_weight'] == $m){
                    $gesamt = $gesamt + $zwischenpreis * $val;
                }
            }


        }
        //echo $gesamt;
        $view->assign('entsorgungspreis', $gesamt);



        // Button was clicked
        $response = $subject->Request()->getParam('response');
        $state = $subject->get('session')->offsetGet('state');

        if(!empty($response)) {
            $subject->get('session')->offsetSet('state', $response);
            $view->assign('state', $response);
            $btnText = $response == 'add' ? 'Entsorgungsgebühr hinzufügen +' : 'Entsorgungsgebühr entfernen x';
            $view->assign('addOrRemoveBtnText', $btnText);

            $bla = $subject->Request()->getParam('bla');
            $view->assign('meinTest', $bla);

        }
        // first state, must be after "button was clicked" because it might override the button request state
        elseif(empty($state)){
            $view->assign('addOrRemoveBtnText', 'Entsorgungsgebühr hinzufügen +');
        }
        // page was refreshed, i.e. by change quantity function, assign the last state
        else{
            $view->assign('state', $state);
            $btnText = $state == 'add' ? 'Entsorgungsgebühr hinzufügen +' : 'Entsorgungsgebühr entfernen x';
            $view->assign('addOrRemoveBtnText', $btnText);
        }

    }

}