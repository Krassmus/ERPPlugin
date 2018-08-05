<input type="text"
       name="form_settings[blocks][<?= htmlReady($block_id) ?>][elements][<?= htmlReady($element_id) ?>][label]"
       value="<?= $form['form_settings']['blocks'][$block_id]['elements'][$element_id]['label'] ?: _("Tragen Sie bitte was ein") ?>"
       class="label-input"
       required>
<input type="text"
       name="form_settings[blocks][<?= htmlReady($block_id) ?>][elements][<?= htmlReady($element_id) ?>][placeholder]"
       value="<?= htmlReady($form['form_settings']['blocks'][$block_id]['elements'][$element_id]['placeholder']) ?>">