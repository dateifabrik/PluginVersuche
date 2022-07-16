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


    // Datenbank


}