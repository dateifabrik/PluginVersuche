<?php

class Shopware_Controllers_Frontend_Test extends Enlight_Controller_Action
{
    public function indexAction(){


        //$this->Front()->Plugins()->ViewRenderer()->setNoRender();
        $myAdd = $this->Request()->getParam('myAdd');
        if($myAdd == "add"){
            $response = "remove";
        }
        else{
            $response = "add";
        }
        $this->redirect(array('controller' => 'checkout', 'action' => 'confirm', 'response' => $response));


    }
}