<?
$form_settings = $form['form_settings'] ? $form['form_settings']->getArrayCopy() : array();
?>
<select name="form_settings[blocks][<?= htmlReady($block_id) ?>][elements][<?= htmlReady($element_id) ?>][format]"
        required>
    <option value=""><?= _("Format des Semesters") ?></option>
    <option value="semester_id"<?= $form_settings['blocks'][$block_id]['elements'][$element_id]['format'] === "semester_id" ? " selected" : "" ?>>
        semester_id
    </option>
    <option value="beginn"<?= $form_settings['blocks'][$block_id]['elements'][$element_id]['format'] === "beginn" ? " selected" : "" ?>>
        <?= _("Semesterstart") ?>
    </option>
</select>
