<?php
/* Wenn die orderNumber irgendwo auf der Seite gebraucht wird
 * kann sie hier übergeben und Daten aus der DB geholt werden
 *
 */

namespace DateifabrikVerpack\Services;

use Doctrine\DBAL\Connection;

class ProductNameService
{


    protected $orderNumber;

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

    public function getNameOfMaterial()
    {

        //$result[] = '';
        //print_r($orderNumber);
        //die();
        $query = $this->connection->createQueryBuilder();

        //foreach($orderNumber as $oN)
        //{
            $query->select(['array_store'])
                ->from('s_attribute_configuration')
                ->where('id = :oID')
                ->setParameter('oID', 10);

            $result = $query->execute()->fetchAll(\PDO::FETCH_COLUMN);
        //}

        return $result;

    }



}