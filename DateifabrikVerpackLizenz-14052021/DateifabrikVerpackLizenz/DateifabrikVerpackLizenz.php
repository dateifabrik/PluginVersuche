<?php

namespace DateifabrikVerpackLizenz;

use Shopware\Components\Plugin;
use Shopware\Components\Plugin\Context\InstallContext;
use Shopware\Components\Plugin\Context\UninstallContext;

class DateifabrikVerpackLizenz extends Plugin
{


    /**
     * @param InstallContext $context
     */

    public function install(InstallContext $context)
    {

        $connection = $this->container->get('dbal_connection');

        $stmt = $connection->prepare('CREATE TABLE dateifabrik_session_test (id INT AUTO_INCREMENT PRIMARY KEY, sessionwert varchar(255) NULL, customernumber VARCHAR(255) NULL)');
        $stmt->execute();


    }

    /**
     * @param UninstallContext $context
     */

    public function uninstall(UninstallContext $context)
    {

        $connection = $this->container->get('dbal_connection');

        $stmt = $connection->prepare('DROP TABLE dateifabrik_session_test');
        $stmt->execute();


    }
    

}
