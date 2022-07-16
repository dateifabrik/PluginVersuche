<?php

namespace DateifabrikLizenzHinweis\Services;

use Doctrine\DBAL\Connection;

class DateifabrikLizenzHinweisService
{
    /**
     * @var $orderNr
     */
    protected $orderNr;

    /** @var Connection */
    private $connection;

    /**
     * DateifabrikLizenzHinweisService constructor.
     * @param Connection $connection
     */
    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }


    public function setLicenseNote($orderNumber)
    {

        $query = $this->connection->createQueryBuilder()
            ->update('s_order', 'so')
            ->set('so.customercomment', ':newCustomercomment')
            ->where('so.ordernumber = :orderNr')
            ->setParameter('newCustomercomment', $this->concatCustomercomment($orderNumber))
            ->setParameter('orderNr', $orderNumber);

        $query->execute();

    }

    public function concatCustomercomment($orderNumber)
    {

        $query = $this->connection->createQueryBuilder()
            ->select("CONCAT('+++ Ich benötige einen Nachweis zu VERPACKG +++\n\n', so.customercomment)") // Text in internem Kommentarfeld mit eigenem Text zusammenführen
            ->from('s_order', 'so')
            ->where('so.ordernumber = :orderNr')
            ->setParameter('orderNr', $orderNumber);

        return $query->execute()->fetchColumn();

    }

}