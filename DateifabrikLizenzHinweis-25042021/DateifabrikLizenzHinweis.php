<?php

namespace DateifabrikLizenzHinweis;

use Shopware\Components\Plugin;
use Shopware\Components\Plugin\Context\InstallContext;
use Shopware\Components\Plugin\Context\UninstallContext;

class DateifabrikLizenzHinweis extends Plugin
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
        $view->addTemplateDir(__DIR__ . '/Resources/views');


        $dateifabrik_lizenz_hinweis_service = $subject->get('dateifabrik_lizenz_hinweis.services.dateifabrik_lizenz_hinweis_service');

        $sOrder = $this->container->get('session')->offsetGet('sOrderVariables');

        if($subject->Request()->getActionName() === 'finish'){

            $licenseChecked = $subject->Request()->getParam('sLICENSE', '');

            // Überlebt das die session???
            if($licenseChecked == 'on'){
                // schreibe in DB
                $dateifabrik_lizenz_hinweis_service->setLicenseNote($sOrder['sOrderNumber']);
            }

        }



    }



}