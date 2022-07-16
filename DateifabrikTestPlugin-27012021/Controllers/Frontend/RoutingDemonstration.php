<?php

/* Die Controller-Klasse beginnt immer mit Shopware_Controllers_FRONT-oder-BACKEND_deinControllername extends Enlight_Controller_Action */
class Shopware_Controllers_Frontend_RoutingDemonstration extends Enlight_Controller_Action
{

    public function preDispatch()
    {
        /*
            - Beispiel, wenn User eingelogt sein soll, bevor er die RoutingDemonstration/index aufrufen kann
            - frage den den ActionNamen aus der Anfrage ab UND ob der user eine sessionID hat
            - falls nicht, redirect mit der loginAction aus dem Account-Controller (engine/Shopware/Controllers/Frontend/Account.php)
            - Parameter für redirect (Ziel): sTarget ist mein Controller 'Routingdemonstration', daraus die gewünschte (index|foo|bla|blub...Action)
        */



        if($this->Request()->getActionName() === 'index' && !$this->get('session')->get('sUserId')){
            $this->redirect([
                'controller' => 'Account',
                'action' => 'login',
                'sTarget' => 'RoutingDemonstration',
                'sTargetAction' => 'foo'
            ]);
        }


        /* Template-Ordner registrieren,
            - SW weiß anhand der URL, welches Template geladen und welche Action darin ausgeführt werden muss.
            - Der Pfad wird ausgehend vom jetzigen Controller eingetragen (absoluter Pfad)
            - Den Slash in der URL also nicht vergessen!!
        */
        $this->view->addTemplateDir(__DIR__. '/../../Resources/views');
    }

    /*
        - indexAction immer notwendig, wird aufgerufen, wenn nichts anderes angegeben ist
        - sonst gilt: Modul->Controller->Action, also hier Frontend->RoutingDemonstration->indexAction

        - entspricht dem Aufruf folgender URL-Varianten:
            domain.tld/frontend/routingDemonstration/index bzw. domain.tld/routingDemonstration/index
            domain.tld/frontend/routingDemonstration bzw. domain.tld/routingDemonstration
            domain.tld/frontend/routing_demonstration/index bzw. domain.tld/routing_demonstration/index
            domain.tld/frontend/routing_demonstration bzw. domain.tld/routing_demonstration
    */
    public function indexAction(){
        /* ### hier nicht mehr notwendig/verwendbar, weil in der postDispatch() aufrufbar ###
            - $currentAction = $this->Request()->getActionName(); // hole den Namen der aktuellen Action aus der Anfrage
            - $this->view->assign('currentAction', $currentAction); // weise der view den Namen der Action zu
        */
        $this->view->assign('nextAction', 'foo');
    }

    /*
        - und hier: Frontend->RoutingDemonstration->fooAction
        - entspricht dem URL-Aufruf domain.tld/routingDemonstration/foo (oder den anderen Varianten wie in Zeilen 22-25)
    */
    public function fooAction(){
        /* ### hier nicht mehr notwendig/verwendbar, weil in der postDispatch() aufrufbar ###
            - $currentAction = $this->Request()->getActionName(); // hole den Namen der aktuellen Action aus der Anfrage
            - $this->view->assign('currentAction', $currentAction); // weise der view den Namen der Action zu
        */
        $this->view->assign('nextAction', 'index');
    }

    public function postDispatch()
    {
        $currentAction = $this->Request()->getActionName(); // hole den Namen der aktuellen Action aus der Anfrage
        $this->view->assign('currentAction', $currentAction); // weise der view den Namen der Action zu
    }
}