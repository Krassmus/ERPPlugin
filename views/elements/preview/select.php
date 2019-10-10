<input type="text"
       name="form_settings[blocks][<?= htmlReady($block_id) ?>][elements][<?= htmlReady($element_id) ?>][label]"
       value="<?= $form['form_settings']['blocks'][$block_id]['elements'][$element_id]['label'] ?: _("Label") ?>"
       class="label-input"
       required>
<select>
    <option value=""></option>
    <? foreach ($options as $option) : ?>
        <option value="<?= htmlReady($option[0]) ?>"><?= htmlReady($option[1]) ?></option>
    <? endforeach ?>
</select>