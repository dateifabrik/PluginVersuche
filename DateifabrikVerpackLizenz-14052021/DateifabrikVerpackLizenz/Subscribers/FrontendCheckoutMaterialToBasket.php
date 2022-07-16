<?php

namespace DateifabrikVerpackLizenz\Subscribers;

use Enlight\Event\SubscriberInterface;

class FrontendCheckoutMaterialToBasket implements SubscriberInterface
{


    public static function getSubscribedEvents()
    {
        return [
            'Enlight_Controller_Action_PostDispatchSecure_Frontend_Checkout' => 'onFinish',
        ];
    }




    public function onFinish(\Enlight_Event_EventArgs $args)
    {
        /** @var \Shopware_Controllers_Frontend_Checkout $subject */
        $subject = $args->getSubject();

        $view = $subject->View();
        //$view->addTemplateDir(__DIR__ . '/../Resources/views');




        /*     $sessiontest = "session_eroeffnet";
             $this->container->get('session')->offsetSet('aaaVariable', $sessiontest);
             $session_id = $this->container->get('sessionId');*/


        $session_wert_service = $subject->get('dateifabrik_verpack_lizenz.services.article_weight_and_material_service');

        // das ist der ganze Basket-Inhalt
        $basket = $subject->getBasket();

        /*
        foreach($basket as $content => $val){
            echo $content . "===>". $val. "<br />";
        }
        die();

        Summe: 230,00 €*
        Versandkosten: 3,90 €*
        Gesamtsumme: 233,90 €
        Gesamtsumme ohne MwSt.: 196,55 €
        zzgl. 19 % MwSt.: 37,35 €


        content===>Array
        Amount===>230,00
        AmountNet===>193,27
        Quantity===>3
        AmountNumeric===>233.9
        AmountNetNumeric===>196.55
        AmountWithTax===>0
        AmountWithTaxNumeric===>0
        sCurrencyId===>1
        sCurrencyName===>EUR
        sCurrencyFactor===>1
        sShippingcostsWithTax===>3.9
        sShippingcostsNet===>3.28
        sShippingcostsTax===>19
        sShippingcostsDifference===>
        sTaxRates===>Array
        sShippingcosts===>3.9
        sAmount===>233.9
        sAmountTax===>37.35

        */

        /*
                foreach($basket['content'] as $content){
                    foreach ($content as $a => $b){
                        if($a == 'quantity') echo $b. "<br />";
                    }
                }
                //die('DateifabrikVerpackLizenz.php Zeile 110');
        */



        if($subject->Request()->getActionName() === 'confirm'){
            /* Berechnungen hier stattfinden lassen,
            dann am Ende in der finish-Action in eine Tabelle eintragen lassem */

            $entsorgungspreis = 0;

            foreach($basket['content'] as $content){

                $articleQuantity = $content['quantity'];
                $articleOrdernumber = $content['ordernumber'];
                $articlePurchaseUnit = $content['purchaseunit'];
                // fetch data from the DB
                $basketArticleWeightData = $session_wert_service->getBasketArticlesWeights($articleOrdernumber);
                // assign data
                $articleWeight = $basketArticleWeightData['weight'];
                $articleMaterial = $basketArticleWeightData['p24_weight'];
                $articleTotalWeight = $articleQuantity * $articlePurchaseUnit * $articleWeight;

                // Berechnung des Preises
                $aluPreis = 0.50;
                $plastikPreis = 0.20;

                if($articleMaterial == 'alu') $preis = $aluPreis;
                if($articleMaterial == 'plastik') $preis = $plastikPreis;

                $entsorgungspreisProArtikel = $articleTotalWeight * $preis;
                $preiseEinzelnArray[] = $entsorgungspreisProArtikel;
                $entsorgungspreis = $entsorgungspreis + $entsorgungspreisProArtikel;


                // prepare response to the view (confirm.tpl)
                $weightDataArray[] = array("totalWeight" => $articleTotalWeight, "quantity" => $articleQuantity, "ordernumber" => $articleOrdernumber, "weight" => $articleWeight, "purchaseunit" => $articlePurchaseUnit, "material" => $articleMaterial);

            }

        }

        $view->assign('weightDataArray', $weightDataArray);
        $view->assign('preisEinzelnArray', $preiseEinzelnArray);
        $view->assign('entsorgungspreis', $entsorgungspreis);

        if($subject->Request()->getParam('field')){
            //die($subject->Request()->getParam('field'));
        }


        $responseFromTestController = $subject->Request()->getParam('response');

        // kann leer sein bei erstem Aufruf
        // kann leer sein bei reload

        if(empty($responseFromTestController) || $responseFromTestController == "add"){
            $addOrRemoveBtnText = "Entsorgungsgebühr hinzufügen +";
            $changeAddOrRemoveBtnState = "add";
        }
        else{
            $addOrRemoveBtnText = "Entsorgungsgebühr entfernen x";
            $changeAddOrRemoveBtnState = "remove";
        }

        $view->assign('addOrRemoveBtnText', $addOrRemoveBtnText);
        $view->assign('changeAddOrRemoveBtnState', $changeAddOrRemoveBtnState);







        // also:
        // wenn sessionvariable für button vorhanden ist: verwenden
        // wenn sessionvariable für entsorgungspreis vorhanden ist: verwenden
        // if (!empty($subject->View()->getAssign('myAdd')))
        // if (!empty($subject->View()->getAssign('buttonzustand')))



        // Erstes betreten: noch nichts vorhanden => entsorgungspreis ausrechnen, in Template schreiben, in Session schreiben
        // Button wird gedrückt: Button Zustand in session schreiben, Button ändert sich, Basket wird erweitert, in session schreiben
        // addArticle oder sku wird hinzugefügt: Zustand des Buttons in session abfragen und wiederherstellen,


        $subject->get('session')->offsetSet('hallo', $entsorgungspreis);


        if($subject->Request()->getParam('myAdd')){
            $entsorgungspreisGesamt = trim($subject->Request()->getParam('myAdd'));
            $view->loadTemplate('frontend/add_material_costs_to_basket/index.tpl');
            $view->assign('hallo', $entsorgungspreisGesamt. ' Euronen');
        }
        else{
            $view->assign('meinTest', $entsorgungspreis. ' Euro');
        }




    }



}