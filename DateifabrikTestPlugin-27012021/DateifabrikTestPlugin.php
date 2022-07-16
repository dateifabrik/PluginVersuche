<?php

namespace DateifabrikTestPlugin;

use Shopware\Components\Plugin;

class DateifabrikTestPlugin extends Plugin
{
    public static function getSubscribedEvents()
    {
        return [
            'Enlight_Controller_Action_PreDispatch_Frontend_RoutingDemonstration' => 'onPreDispatch'
        ];
    }

    public function onPreDispatch(\Enlight_Event_EventArgs $args)
    {
        /** @var \Shopware_Controllers_Frontend_RoutingDemonstration $subject */
        $subject = $args->getSubject();
    }
}