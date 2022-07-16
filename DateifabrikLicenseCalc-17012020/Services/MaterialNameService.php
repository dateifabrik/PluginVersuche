<?php

namespace DateifabrikLicenseCalc\Services;

use Doctrine\DBAL\Connection;

class MaterialNameService
{

    protected $tableName = "s_articles_attributes";

    /** @var Connection */
    private $connection;

    /**
     * ProductNameService constructor.
     * @param Connection $connection
     */
    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }


    public function getColumnName($label)
    {

        // SELECT column_name FROM s_attribute_configuration WHERE label = "Material" AND table_name = "s_articles_attributes"
        // SELECT array_store FROM s_attribute_configuration WHERE table_name = "s_articles_attributes" && column_name = "$columnName"

        $query = $this->connection->createQueryBuilder();

        $query->select(['column_name'])
            ->from('s_attribute_configuration')
            ->where('label = :label AND table_name = :tableName')
            ->setParameter('label', $label)
            ->setParameter('tableName', $this->tableName);

        $result = $query->execute()->fetchAll(\PDO::FETCH_COLUMN);

        return $result;

    }

    public function getArrayStore($column_name)
    {

        // SELECT column_name FROM s_attribute_configuration WHERE label = "Material" AND table_name = "s_articles_attributes"
        // SELECT array_store FROM s_attribute_configuration WHERE table_name = "s_articles_attributes" && column_name = "$columnName"

        $query = $this->connection->createQueryBuilder();

        $query->select(['array_store'])
            ->from('s_attribute_configuration')
            ->where('column_name = :columnName AND table_name = :tableName')
            ->setParameter('columnName', $column_name)
            ->setParameter('tableName', $this->tableName);

        $result = $query->execute()->fetchAll(\PDO::FETCH_COLUMN);

        return $result;

    }



}