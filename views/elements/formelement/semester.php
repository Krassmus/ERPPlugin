<label>
    <?= htmlReady($form['form_settings']['blocks'][$block_id]['elements'][$element_id]['label']) ?>
    <select name="<?= htmlReady($name) ?>">
        <option value=""></option>
        <? foreach (array_reverse(Semester::getAll()) as $semester) : ?>
            <?
            $temp_value = $form['form_settings']['blocks'][$block_id]['elements'][$element_id]['format'] === "beginn"
                ? $semester['beginn']
                : $semester->getId();
            ?>
            <option value="<?= htmlReady($temp_value) ?>"<?= $temp_value === $value ? " selected" : "" ?>>
                <?= htmlReady($semester['name']) ?>
            </option>
        <? endforeach ?>
    </select>
</label>