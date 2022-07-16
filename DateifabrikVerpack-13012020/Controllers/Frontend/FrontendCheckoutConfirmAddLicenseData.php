<?php

namespace DateifabrikVerpack\Controllers\Frontend;

use Enlight\Event\SubscriberInterface;

class FrontendCheckoutConfirmAddLicenseData implements SubscriberInterface
{

    public static function getSubscribedEvents()
    {
        return [
            'Enlight_Controller_Action_PostDispatchSecure_Frontend_Checkout' => 'onPostDispatchCheckout'
        ];
    }


    public function onPostDispatchCheckout(\Enlight_Event_EventArgs $args)
    {

        /** @var \Shopware_Controllers_Frontend_Checkout $checkoutController */

        $checkoutController = $args->getSubject();
        $view = $checkoutController->View();

        $view->addTemplateDir(__DIR__ . '/../../Resources/views/');


        $from_db = $checkoutController->get('dateifabrik_verpack.services.product_name_service');
        $db_data = $from_db->getNameOfMaterial();

        foreach($db_data as $test)
        {
            foreach(json_decode($test) as $item)
            {
                if($item->key == 'cardboard') $jsonMaterialName = $item->value;
            }

        }

        $view->assign('dbank', $db_data);


        $basket = Shopware()->Modules()->Basket()->sGetBasket();

/*
        echo "<pre>";
        print_r($db_data);
        echo "</pre>";
        die();
*/
        /* TODO möglichst noch in der Plugin-Konfiguration hinterlegen, falls nichts in isy_einzelgewicht hinterlegt ist */
        $pauschalgewicht = "10000000";

        $count = 1;



        foreach($basket['content'] as $gewicht){

            $isy_einzelgewicht = $gewicht['additional_details']['attributes']['core']->get('isy_einzelgewicht');
            $isy_einzelgewicht = $isy_einzelgewicht == "" ? $pauschalgewicht : $isy_einzelgewicht;

            $material = $gewicht['additional_details']['attributes']['core']->get('material');
            $material = $material == "" ? "ohne Angabe" : $material;

            $quantity = $gewicht['quantity'];
            $purchaseUnit = $gewicht['purchaseunit'];
            $anzahl = "(quantity) ". $quantity. " * (isy_einzelgewicht) ". $isy_einzelgewicht. " * (purchaseunit) " . $purchaseUnit. " = ";

            // make the isy_einzelgewicht string to float
            $frontweight[] = $quantity * $purchaseUnit * floatval(str_replace(',','.', $isy_einzelgewicht));

            $frontweight_string[] = "Material Artikel ". $count. ": ". $jsonMaterialName. " (". $material. ")<br />Rechenweg: ". $anzahl . str_replace('.', ',', $quantity * $purchaseUnit * floatval(str_replace(',','.', $isy_einzelgewicht))). "<br /><br />";

            $count++;
        }


        // in frontend as array
        $view->assign('arr_gewicht', $frontweight_string);


        // in frontend as sum
        $frontweight = array_sum($frontweight);
        $view->assign('gewicht', $frontweight);

    }


}
