{extends file='parent:frontend/checkout/confirm.tpl'}

{block name='frontend_checkout_confirm_tos_panel'}
    {$smarty.block.parent}

    {* Block für Lizenzierung *}
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
                                <h5>Stichworte</h5>
                                <li>AJAX bekommt Artikeldaten und Logik aus einer PHP-Datei (Controller?)</li>
                                <li>postDispatch</li>
                                <li>scripte (jQuery und eigene) an richtiger Stelle hinterlegen</li>
                                <li>https://www.biologischverpacken.de/verpackg</li>
                            </ul>
                        </div>
                        <br />
                    </span>

                    <span class="block column--checkbox">
                        <input type="checkbox" id="sLICENSE" name="sLICENSE" value="1" />
                    </span>
                    <span class="block column--label">
                        <label for="sLICENCSE">Ich benötige eine Lizenzierung nach <a href="https://verpackungsgesetz-info.de/" target="_blank"><span style="text-decoration: underline;">VerpackG</span></a> vom 01.01.2019.</label>
                        <ul id="myoutput" style="display: none;">
                            <p style="display: inline-block; margin: 0 -0.5rem; padding: 0 0.5rem; background: yellow;">Die VerpackG Lizenzgebühren wurden der Preisberechnung hinzugefügt.</p>
                            {for $i=0 to {{$sBasket.content|count} - 1}} {* Starte bei 0 (wegen array $sBasket.content[$i], bis Anzahl der Artikel im Warenkorb *}
                                {foreach $sBasket.content[$i].additional_details.attributes.core->get('isy_einzelgewicht') as $isy_weight}
                                  {$isy_weights = {$isy_weight|replace:",":"."|floatval} * 1000.6432} {* Multiplikation mit festgelegtem Standard-Materialgewicht, ideralerweise aus DB, eingetragen im Plugin *}
                                  <li><b>Gewicht Artikel {$i}:</b> {$isy_weights}</li>
                                {/foreach}
                            {/for}

                        </ul>
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