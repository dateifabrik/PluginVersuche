{extends file='parent:frontend/checkout/confirm.tpl'}

{block name='frontend_checkout_confirm_form'}
    {$smarty.block.parent}
{*
    <div class="tos--panel panel has--border" xmlns="http://www.w3.org/1999/html">
        <div class="panel--title primary is--underline" style="margin: 0; padding-left: 1.25rem; padding-right: 1.25rem; background: yellow;">
            Lizenzierung nach VerpackG 01.01.2019
        </div>

        <div class="panel--body is--wide">
            <ul class="list--checkbox list--unstyled">
                <li class="block-group row--tos">
                    *}
{* Lizenzierung *}{*

                    <div class="block">
                        <a href="{url controller='AddDisposalFee' action=$action}">
                            <button class="btn is--primary m-0" {$state}>Entsorgungsgebühr hinzufügen</button>
                        </a>
                    </div>
                    <div class="block">
                        <p>Entsorgungskosten: <b>{$disposalFee}</b> Euro</p>
                        {foreach $materials as $m}
                            Material: {$m}
                        {/foreach}
                    </div>
                </li>
            </ul>
        </div>
    </div>
*}

    <div class="panel has--border">
        <h3 class="panel--title is--underline">Lizenzierung nach VerpackG 01.01.2019</h3>
        <div class="panel--body">
            <div style="vertical-align: top;">
                <a class="is--inline-block" style="padding: 0.5rem;" href="{url controller='AddDisposalFee' action=$action}">
                    <button class="btn is--primary m-0" {$state}>Entsorgungsgebühr hinzufügen</button>
                </a>
                <p class="is--inline-block" style="padding: 0.5rem;">Entsorgungsgebühr für den gesamten Warenkorb: <b>{$disposalFee} €</b> <span class="icon--info2"></span></p>
            </div>
            <div class="is--inline-block">
                <p style="padding: 0.5rem;">
                    Die Entsorgungsgebühr wird wie ein Artikel behandelt und zum Warenkorb hinzugefügt. Es handelt sich bei der angegebenen Summe um eine Schätzung für die Entsorgungsgebühr bei Versand innerhalb Deutschlands.
                    Packing24 ist im Verpackungsregister <a href="www.verpackungsregister.org" target="_blank">(www.verpackungsregister.org)</a> unter der Registrierungsnummer DE4094079872907-V zu finden.
                </p>
            </div>
        </div>
    </div>

    <div>
        <h5>Material ArrayTest</h5>
        {foreach $materials as $m}
            Material: {$m}
        {/foreach}
    </div>

{/block}