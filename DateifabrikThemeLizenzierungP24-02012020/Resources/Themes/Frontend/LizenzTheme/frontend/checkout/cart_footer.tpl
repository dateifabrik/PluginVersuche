{extends file='parent:frontend/checkout/cart_footer.tpl'}

{block name='frontend_checkout_cart_footer_field_labels_sum'}
    {$smarty.block.parent}

    {* Zusammenfassung Lizenz *}
    <li class="list--entry block-group mycartfooter" style="margin: 0 -0.5rem; padding: 0 0.5rem; background: yellow; display: none;">
        <div class="entry--label block">
            VerpackG Lizenzgebühren
        </div>
        <div class="entry--value block is--no-star">
            {"bla"|currency}
        </div>
    </li>
    {debug}
{/block}