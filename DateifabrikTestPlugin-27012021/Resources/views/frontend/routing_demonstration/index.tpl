{extends file="parent:frontend/index/index.tpl"}

{block name='frontend_index_content'}
    <!--
        - siehe DateifabrikTestPlugin->Controllers->Frontend->RoutingDemonstration in postDispatch()
        - $this->view->assign('currentAction', $currentAction) <- hier wird die Variable zugewiesen
    -->
    <h1>{$currentAction}-Action</h1>
    <!--
        - Modifier erzeugt Shopware-Link: url plus Angabe des Controllers und der gewünschten Action
        - wird durch Version mit snippet in Resources/snippets/frontend/routing_demonstration/index.ini ersetzt
    -->
    <!-- <a href="{url controller='RoutingDemonstration' action=$nextAction}">nextAction</a> -->

    <a href="{url controller='RoutingDemonstration' action=$nextAction}">
        {* snippet *}
        {s name="GoToNextPage"}{/s}
    </a>

{/block}