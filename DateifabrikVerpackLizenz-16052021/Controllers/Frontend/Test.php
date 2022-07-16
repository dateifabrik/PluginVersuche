<?php

class Shopware_Controllers_Frontend_Test extends Enlight_Controller_Action
{
    public function indexAction(){

        //$this->Front()->Plugins()->ViewRenderer()->setNoRender();
        $state = $this->Request()->getParam('state');
        $response = (empty($state) || $state == 'add') ? 'remove' : 'add';
        $bla = 'bla';
        $this->redirect(array('controller' => 'checkout', 'action' => 'confirm', 'response' => $response, 'bla' => $bla));

    }
}