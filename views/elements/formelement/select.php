<? $form_settings = $form->form_settings ? $form->form_settings->getArrayCopy() : array() ?>
<label>
    <?= htmlReady($form_settings['blocks'][$block_id]['elements'][$element_id]['label']) ?>
    <select <? if (!$readonly) : ?>
            name="<?= htmlReady($name) ?>"
        <? else : ?>
            readonly disabled
        <? endif ?>>
        <option value=""></option>
        <? foreach ($options as $option) : ?>
            <option value="<?= htmlReady($option[0]) ?>"<?= $option[0] == $value ? " selected" : "" ?>><?= htmlReady($option[1]) ?></option>
        <? endforeach ?>
    </select>
</label>
