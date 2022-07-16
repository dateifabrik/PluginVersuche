<?php

// siehe auch https://github.com/marcmanusch/PaulCheckoutSurvey
// https://www.biologischverpacken.de/verpackg



namespace DateifabrikDisposalFee;

use Shopware\Components\Plugin;
use Shopware\Components\Plugin\Context\InstallContext;
use Shopware\Components\Plugin\Context\UninstallContext;

class DateifabrikDisposalFee extends Plugin
{


    /**
     * @param InstallContext $context
     */

    public function install(InstallContext $context)
    {

        $connection = $this->container->get('dbal_connection');

        //$stmt = $connection->prepare('CREATE TABLE dateifabrik_disposal_fee (id INT AUTO_INCREMENT PRIMARY KEY, sessionwert varchar(255) NULL, customernumber VARCHAR(255) NULL)');
        $stmt = $connection->prepare('CREATE TABLE dateifabrik_disposal_fee (id INT AUTO_INCREMENT PRIMARY KEY, sessionID varchar(255) NULL, alu varchar(255) NULL, plastik VARCHAR(255) NULL)');
        $stmt->execute();


    }

    /**
     * @param UninstallContext $context
     */

    public function uninstall(UninstallContext $context)
    {

        $connection = $this->container->get('dbal_connection');

        $stmt = $connection->prepare('DROP TABLE dateifabrik_disposal_fee');
        $stmt->execute();


    }




}
