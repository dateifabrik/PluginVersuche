{extends file='parent:frontend/checkout/confirm.tpl'}

{block name='frontend_checkout_confirm_tos_panel'}
    {$smarty.block.parent}

    <div class="tos--panel panel has--border">
        <div class="panel--title primary is--underline" style="margin: 0; padding-left: 1.25rem; padding-right: 1.25rem; background: yellow;">
            Lizenzierung nach VerpackG
        </div>

        <div class="panel--body is--wide">
            <ul class="list--checkbox list--unstyled">
                <li class="block-group row--tos">
                    {* Lizenzierung *}
                    <span class="block">
                        <div class="panel--body">
                            <span class="block column--label">
                                <input type="checkbox" id="sLICENSE" class="inputUncheck" name="sLICENSE" style="margin-right: 0.5rem;"/>
                                <label for="sLICENCSE">Ich benötige eine Lizenzierung nach <a href="https://verpackungsgesetz-info.de/" target="_blank"><span style="text-decoration: underline;">VerpackG</span></a> und bitte um einen Nachweis für die "Zentrale Stelle Verpackungsregister".</label>
                            </span>
                        </div>
                    </span>
                </li>
            </ul>
        </div>
    </div>

{/block}