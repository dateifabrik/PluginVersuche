{* extends file="parent:frontend/index/index.tpl" *}
<!-- doppelter Code vorher in beiden Dateien (index.tpl und foo.tpl), daher besser den von der eigenen routing_demonstration/index.tpl übernehmen -->
{extends file="parent:frontend/routing_demonstration/index.tpl"}

{block name='frontend_index_content'}
    {$smarty.block.parent}
    <h3>weiterer Text nach dem Inhalt des übergeordneten Templates (routing_demonstration/index.tpl)</h3>

    <!--
        - Widget einbinden: zu finden unter engine/Shopware/Controllers/Widgets
        - entsprechenden Controller ausfindig machen, z.B. Listing
        - in dem Controller Listing dann die enstsprechende Action aussuchen und wie folgt einbinden:
    -->
    {* Widget einbinden *}
    {action module='Widgets' controller='Listing' action='topSeller'}
{/block}

<!-- JETZT NICHT MEHR NOTWENIG DER CODE, wäre sonst doppelt gemoppelt -->
{* block name='frontend_index_content' *}
    <!--
        - siehe DateifabrikTestPlugin->Controllers->Frontend->RoutingDemonstration in postDispatch()
        - $this->view->assign('currentAction', $currentAction) <- hier wird die Variable zugewiesen
    -->
    <!-- <h1>{$currentAction}-Action</h1>-->
    <!--
        - Modifier erzeugt Shopware-Link: url plus Angabe des Controllers und der gewünschten Action
    -->
    <!-- <a href="{url controller='RoutingDemonstration' action=$nextAction}">nextAction</a> -->
{* /block *}