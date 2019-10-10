<?
$form_settings = $form['form_settings'] ? $form['form_settings']->getArrayCopy() : array();
?>

<textarea name="form_settings[blocks][<?= htmlReady($block_id) ?>][elements][<?= htmlReady($element_id) ?>][value]"
       placeholder="<?= _("Dieser Wert wird in die Zelle der Datenbanktabelle geschrieben.") ?>"><?= htmlReady($form_settings['blocks'][$block_id]['elements'][$element_id]['value']) ?></textarea>

