<? $form_settings = $form->form_settings ? $form->form_settings->getArrayCopy() : array() ?>
<label>
    <input type="hidden" name="<?= htmlReady($name) ?>" value="0">
    <input type="checkbox"
           name="<?= htmlReady($name) ?>"
           value="1"<?= $value ? " checked" : "" ?>>
    <?= htmlReady($form_settings['blocks'][$block_id]['elements'][$element_id]['label']) ?>
</label>
