<?php

/* -----------------------------------------------------------------------------------------------------------------
 *
 * Ändere Daten des Artikels beim "in-den-Warenkorb" legen, zum Beispiel den Netto-Preis
 *
 */

/*
 * verfügbare Daten:
 *    Array
         (
             [0] => Array
                 (
                     [pricegroup] => EK
                     [price] => 25.210084033613
                     [taxID] => 1
                     [tax] => 19.00
                     [tax_rate] => 19
                     [articleDetailsID] => 3
                     [articleID] => 3
                     [config] =>
                     [ordernumber] => SW10003
                     [from] => 1
                     [to] => beliebig
                 )
         )
 ----------------------------------------------------------------------------------------------------------------- */


/*

namespace DateifabrikDisposalFee\Subscriber;

use Enlight\Event\SubscriberInterface;


class Tests implements SubscriberInterface
{

    public static function getSubscribedEvents()
    {
        return [
            'Shopware_Modules_Basket_getPricesForItemUpdates_FilterCartItemPrices' => 'onFilterPrice',
            ];
    }


    public function onFilterPrice(\Enlight_Event_EventArgs $args)
    {

        $arr = $args->getReturn();
        foreach ($arr as $b) {
            $b['price'] = $b['price'] * 2;
            $arr[] = $b;
        }

        $args->setReturn($arr);

    }


}

*/