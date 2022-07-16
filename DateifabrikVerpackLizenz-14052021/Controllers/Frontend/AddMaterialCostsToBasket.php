<?php



//use DateifabrikVerpackLizenz\Subscribers\FrontendCheckoutMaterialToBasket as Material;

class Shopware_Controllers_Frontend_AddMaterialCostsToBasket extends Enlight_Controller_Action
{
    public function indexAction(){


        die('AddMaterialCostsToBasket');
/*        if (strtolower($this->Request()->getMethod()) !== 'post') {
            throw new \LogicException('This action only admits post requests');
        }*/

        //$this->Front()->Plugins()->ViewRenderer()->setNoRender();
        //$this->redirect(array('controller' => 'checkout', 'action' => 'confirm', 'getParamaterName' => 'getParameterWert'));

        // TODO Summe nicht aus dem Request holen, sondern funktion schreiben und dafür dbal-service nutzen
        $entsorgungspreisGesamt = trim($this->Request()->getParam('myAdd'));
        //$this->View()->addTemplateDir(__DIR__. '/../../Resources/views');
        $this->View()->loadTemplate('frontend/add_material_costs_to_basket/index.tpl');
        $this->View()->assign('hallo', $entsorgungspreisGesamt. ' Euro');





//        $dssdfsf = new Material();
//        $dssdfsf->test('fgffdgxfdsdgdsddffdfgfgfgfdgfg');
//        die('fdgfgdfg');

//        $test = $this->container->get('dateifabrik_verpack_lizenz.subscribers.frontend_checkout_material_to_basket');
//        print_r($test->test($entsorgungspreisGesamt));
//
//
//
//
//
//        echo "
//        <ul>
//            <li>
//                jetzt muss der basket erweitert werden und der button muss den zustand wechseln zum daten wieder entfernen
//            </li>
//            <br />
//            <li>
//                bei finishAction werden die Daten gespeichert, position entsorgungskosten werden wie ein artikel in der order-tabelle gespeichet
//            </li>
//            <br />
//            <li>
//                dann werden die einzelnen bestandteile (bestellnummer, bestellID, alu in gramm, plastik in gramm (eventuell sogar schon zusammenaddiert) u.s.w. in einer extra-tabelle abgelegt
//
//
//            </li>
//        </ul>
//
//        ";
//
//        $ordernumber = trim($this->Request()->getParam('sAdd'));
//        print_r($ordernumber);



    }
}