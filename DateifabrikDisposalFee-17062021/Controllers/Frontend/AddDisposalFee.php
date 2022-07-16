<?php

class Shopware_Controllers_Frontend_AddDisposalFee extends Enlight_Controller_Action{

    public function indexAction(){
        //$this->Front()->Plugins()->ViewRenderer()->setNoRender();
/*        $state = $this->Request()->getParam('state');
        $response = (empty($state) || $state == 'add') ? 'remove' : 'add';
        $this->redirect(array('controller' => 'checkout', 'action' => 'confirm', 'response' => $response));*/


        $this->container->get('session')->offsetSet('state', 'disabled');
        $this->container->get('session')->offsetSet('add', 'add');
        $this->redirect(array('controller' => 'checkout', 'action' => 'confirm'));

    }

}