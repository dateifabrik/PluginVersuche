<?php

namespace DateifabrikLicenseCalc;

use Shopware\Components\Plugin;
use Shopware\Components\Plugin\Context\InstallContext;
use Shopware\Components\Plugin\Context\ActivateContext;
use Shopware\Components\Plugin\Context\DeactivateContext;
use Shopware\Components\Plugin\Context\UninstallContext;

class DateifabrikLicenseCalc extends Plugin
{

    public function install(InstallContext $context)
    {
        $service = $this->container->get('shopware_attribute.crud_service');
        $service->update('s_user_attributes', 'dateifabrik_verpackg_license_every_order', 'boolean');

        $message = '<p>Das Plugin wurde installiert und muss noch aktiviert werden.</p>';
        $context->scheduleMessage($message);

    }

    public function activate(ActivateContext $context)
    {
        $context->scheduleClearCache(InstallContext::CACHE_LIST_DEFAULT);
        $message = '<p>Das Plugin wurde aktiviert.</p>';
        $context->scheduleMessage($message);
    }

    public function deactivate(DeactivateContext $context)
    {
        $context->scheduleClearCache(InstallContext::CACHE_LIST_DEFAULT);
        $message = '<p>Das Plugin wurde deaktiviert.</p>';
        $context->scheduleMessage($message);
    }

    public function uninstall(UninstallContext $context)
    {
        if ($context->keepUserData()) {
            return;
        }
        $service = $this->container->get('shopware_attribute.crud_service');
        $service->delete('s_user_attributes', 'dateifabrik_verpackg_license_every_order');

        $message = '<p>Das Plugin wurde deinstalliert. Bitte unbedingt unter<br /><br >Einstellungen->Caches / Performance den<br /><br /><span style="font-weight: bolder; font-size: .75rem;">Cache für Proxy-Objekte löschen!!!</span></p>';
        $context->scheduleMessage($message);
    }



}
