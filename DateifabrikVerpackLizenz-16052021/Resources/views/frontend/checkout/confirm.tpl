{extends file='parent:frontend/checkout/confirm.tpl'}

{block name='frontend_checkout_confirm_form'}
    {$smarty.block.parent}
    <div class="tos--panel panel has--border" xmlns="http://www.w3.org/1999/html">
        <div class="panel--title primary is--underline" style="margin: 0; padding-left: 1.25rem; padding-right: 1.25rem; background: yellow;">
            Lizenzierung nach VerpackG 01.01.2019
        </div>

        <div class="panel--body is--wide">
            <ul class="list--checkbox list--unstyled">
                <li class="block-group row--tos">
                    {* Lizenzierung *}
                    <span class="block">
                        <div class="panel--body">

                                <a href="{url controller='test' action='index' state=$state}">
                                    <button class="btn is--primary">{$addOrRemoveBtnText}</button>
                                </a>

                            <ul>
                                {if $meinTest == 'bla'}
                                    {block name='frontend_checkout_confirm_test'}
                                        {include file="frontend/test/index.tpl"}
                                    {/block}
                                {/if}





                                {foreach $preisEinzelnArray as $preisEinzeln}
                                    <li>+ {$preisEinzeln}</li>
                                {/foreach}
                            </ul>


                            <p>Entsorgungskosten: {$entsorgungspreis} Euro</p>

{*

                                <p>
                                    Wenn Lizenz im Kundenkonto = 0, dann Abfrage<br />
                                    wenn 1, dann Hinweis und Link zum Kundenkonto
                                </p>

                                <p class="panel--actions">
                                <button type="submit" id="sTEST" name="sTEST" value="meinValue" />Entsorgungsgebühr hinzufügen</button>
                                    <br />
                                    <span>Klick = Entsorgungskosten hinzufügen, nächster klick entfernt Entsorgungskosten, wenn Status des Buttons auf "bereits geklickt" steht</span>
                                </p>

                                <input type="checkbox" id="sLICENSE" class="inputUncheck" name="sLICENSE" style="margin-right: 0.5rem;"/>
                                <label for="sLICENCSE">Ich benötige eine Lizenzierung nach <a href="https://verpackungsgesetz-info.de/" target="_blank"><span style="text-decoration: underline;">VerpackG</span></a> und bitte um einen Nachweis für die "Zentrale Stelle Verpackungsregister".</label>
                                <br />
                                <input type="checkbox" id="sLICENSE-ON-EVERY-ORDER" class="inputUncheck" name="sLICENSE-ON-EVERY-ORDER" style="margin-right: 0.5rem;"/>
                                <label for="sLICENSE-ON-EVERY-ORDER">
                                    Die Lizenzierung soll automatisch, auch für zukünftige Bestellungen, bis auf Widerruf durchgeführt werden.
                                </label>


                                <ul id="myoutput" class="listing--container list-unstyled">
                                    {foreach $weightDataArray as $weightData}
                                        <li>Material: {$weightData['material']}, Gesamtgewicht: {$weightData['totalWeight']} Gramm, Verpackungseinheit: {$weightData['purchaseunit']|number_format:0:",":""}, Anzahl: {$weightData['quantity']}, Bestellnummer: {$weightData['ordernumber']}, Gewicht: {$weightData['weight']}</li>
                                    {/foreach}
                                </ul>
*}

                        </div>
                    </span>
                </li>
            </ul>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script>

        // Checkbox für Lizenzierung darf bei onLoad || reload nicht angehakt, also false sein
        /*
        $('input.inputUncheck').prop('checked', false);

        $("#sLICENSE").change(function(event) {
            $("ul#myoutput,.mycartfooter").toggle(200);
        });
        */
    </script>

{/block}