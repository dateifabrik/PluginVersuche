{extends file='parent:frontend/checkout/cart_footer.tpl'}

{block name='frontend_checkout_cart_footer_field_labels_shipping'}

{$smarty.block.parent}


        <li class="list--entry block-group">

                <div class="entry--label block">
                    {"Lizenzgebühren:"}
                </div>


                <div class="entry--value block">
                    {$gewicht}
                </div>

        </li>


{/block}