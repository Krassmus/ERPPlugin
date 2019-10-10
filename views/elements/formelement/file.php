<? $form_settings = $form->form_settings ? $form->form_settings->getArrayCopy() : array() ?>
<label class="file-upload">
    <?= htmlReady($form_settings['blocks'][$block_id]['elements'][$element_id]['label']) ?>
    <input type="file"
            <? if (!$readonly) : ?>
           name="<?= htmlReady($name) ?>"
            <? else : ?>
            readonly disabled
            <? endif ?>
           placeholder="<?= htmlReady($form['form_settings']['blocks'][$block_id]['elements'][$element_id]['placeholder']) ?>"
           value="<?= htmlReady($value) ?>">
</label>
