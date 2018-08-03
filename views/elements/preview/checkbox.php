<input type="checkbox">
<input type="text"
       name="form_settings[blocks][<?= htmlReady($block_id) ?>][elements][<?= htmlReady($element_id) ?>][label]"
       value="<?= htmlReady($form['form_settings']['blocks'][$block_id]['elements'][$element_id]['label']) ?>">