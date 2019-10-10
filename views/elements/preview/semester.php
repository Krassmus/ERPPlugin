<input type="text"
       name="form_settings[blocks][<?= htmlReady($block_id) ?>][elements][<?= htmlReady($element_id) ?>][label]"
       value="<?= $form['form_settings']['blocks'][$block_id]['elements'][$element_id]['label'] ?: _("Semester") ?>"
       class="label-input"
       required>
<select>
    <option value=""></option>
    <? foreach (array_reverse(Semester::getAll()) as $semester) : ?>
        <option><?= htmlReady($semester['name']) ?></option>
    <? endforeach ?>
</select>