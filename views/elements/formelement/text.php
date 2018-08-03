<? $form_settings = $form->form_settings ? $form->form_settings->getArrayCopy() : array() ?>
<label>
    <?= htmlReady($form_settings['blocks'][$block_id]['elements'][$element_id]['label']) ?>
    <input type="text"
           name="<?= htmlReady($name) ?>"
           placeholder="<?= htmlReady($form['form_settings']['blocks'][$block_id]['elements'][$element_id]['placeholder']) ?>"
           value="<?= htmlReady($value) ?>">
</label>
