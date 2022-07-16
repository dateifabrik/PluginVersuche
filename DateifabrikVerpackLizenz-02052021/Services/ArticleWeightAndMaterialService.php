<?php

namespace DateifabrikVerpackLizenz\Services;

use Doctrine\DBAL\Connection;

class ArticleWeightAndMaterialService
{
    /**
     * @var $orderNr
     */
    protected $orderNr;

    /** @var Connection */
    private $connection;

    /**
     * ArticleWeightAndMaterialService constructor.
     * @param Connection $connection
     */
    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }
/*
    public function setSessionWert($sessionId)
    {

        $query = $this->connection->createQueryBuilder()
            ->insert('dateifabrik_session_test')
            ->values(
                array(
                    'sessionwert' => '?',
                    'customernumber' => '?'
                )
            )
            ->setParameter(0, $sessionId)
            ->setParameter(1, $this->getCustomerNumber($sessionId));

        $query->execute();

    }

    public function getCustomerNumber($sessionId)
    {

        $query = $this->connection->createQueryBuilder()
            ->select(['u.customernumber'])
            ->from('s_user', 'u')
            ->where('u.sessionID = :sID')
            ->setParameter('sID', $sessionId);

        return $query->execute()->fetchColumn();

    }*/

    /*SAMMLE DIE ORDERNUMBER ODER SONSTIGES UND HOLE DAMIT DAS GEWICHT AUS DER ATTR TABELLE UND RETURNE ES NACH HIER,
    DAMIT ES BASKET ANGEZEIGT WERRDEN KANN*/


    public function getBasketArticlesWeights($orderNr)
    {

        $query = $this->connection->createQueryBuilder()
            ->select(['sad.weight', 'saa.p24_weight'])
            ->from('s_articles_details', 'sad')
            ->innerJoin('sad', 's_articles_attributes', 'saa', 'sad.articleID = saa.articledetailsID')
            ->where('sad.ordernumber = :orderNr') // :orderNr ist ein alias für
            ->setParameter('orderNr', $orderNr); // hier - hier wird die übergebene $orderNr an orderNr übergeben

        return $query->execute()->fetch();


    }

}