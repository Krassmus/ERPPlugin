<input type="text"
       name="form_settings[blocks][<?= htmlReady($block_id) ?>][elements][<?= htmlReady($element_id) ?>][label]"
       value="<?= $form['form_settings']['blocks'][$block_id]['elements'][$element_id]['label'] ?: _("Tragen Sie bitte was ein") ?>"
       required>
<textarea
       name="form_settings[blocks][<?= htmlReady($block_id) ?>][elements][<?= htmlReady($element_id) ?>][placeholder]"
    ><?= htmlReady($form['form_settings']['blocks'][$block_id]['elements'][$element_id]['placeholder']) ?></textarea>