{extends file='parent:frontend/checkout/confirm.tpl'}

{block name='frontend_checkout_confirm_tos_panel'}
    {$smarty.block.parent}

    <div class="tos--panel panel has--border">
        <div class="panel--title primary is--underline" style="margin: 0; padding-left: 1.25rem; padding-right: 1.25rem; background: yellow;">
            Lizenzierung nach VerpackG 01.01.2019
        </div>

        <div class="panel--body is--wide">
            <ul class="list--checkbox list--unstyled">
                <li class="block-group row--tos">
                    {* Lizenzierung *}

                    <span class="block">
                        <h5>Template an dieser Stelle so vorbereiten, daß beim Ändern der Radio- oder Checkbox die Daten aus den Freitextfeldern oder - noch besser - die neu angelegten Artikel direkt hier darunter geladen oder ausgeblendet werden. Das muss später auf die Artikelauflistung übertragen werden.</h5>
                        <div class="panel--body">
                            <ul class="listing--container">
                                <li>scripte (jQuery und eigene) an richtiger Stelle hinterlegen</li>
                                <li>https://www.biologischverpacken.de/verpackg</li>
                                <li><a href="https://forum.shopware.com/discussion/comment/216399/" target="_blank">jquery-ajax-und-eigener-frontend-controller</a></li>
                                <li><a href="https://forum.shopware.com/discussion/43961/wahrend-einer-bestellung-der-bestellung-ein-bild-hinzufuegen" target="_blank">WÄHREND einer Bestellung der Bestellung ein Bild hinzufügen</a></li>
                            </ul>
                            <p></p>
                            <span class="block column--checkbox">
                                <input type="checkbox" id="sLICENSE" name="meineLizenz"{if $sLICENSEChecked} checked="checked"{/if} />
                            </span>
                            <span class="block column--label">
                                <label for="sLICENCSE">Ich benötige eine Lizenzierung nach <a href="https://verpackungsgesetz-info.de/" target="_blank"><span style="text-decoration: underline;">VerpackG</span></a> vom 01.01.2019.</label>
                                <ul id="myoutput" class="listing--container" style="margin-top: 1rem;/*display: none;*/">
                                    {foreach $weighting_for_you as $item}
                                        <li style="margin-bottom: 10px;">
                                            <b>{$item['article_name']}</b><br />
                                            Material: {$item['material']}<br />
                                            {$item['quantity']} * {$item['purchase_unit']} Stück * {$item['single_weight']}g = {$item['total_item_weight']}g
                                        </li>
                                    {/foreach}
                                </ul>
                            </span>


                        </div>
                    </span>
                </li>

        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script>
        $("#sLICENSE").change(function(event) {
            $("ul#myoutput,.mycartfooter").toggle(400);
        });
    </script>

{/block}
