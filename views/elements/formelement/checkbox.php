<? $form_settings = $form->form_settings ? $form->form_settings->getArrayCopy() : array() ?>
<label>
    <? if (!$readonly) : ?>
        <input type="hidden" name="<?= htmlReady($name) ?>" value="0">
    <? endif ?>
    <input type="checkbox"
            <? if (!$readonly) : ?>
                name="<?= htmlReady($name) ?>"
            <? else : ?>
                readonly disabled
            <? endif ?>
           value="1"<?= $value ? " checked" : "" ?>>
    <?= htmlReady($form_settings['blocks'][$block_id]['elements'][$element_id]['label']) ?>
</label>
