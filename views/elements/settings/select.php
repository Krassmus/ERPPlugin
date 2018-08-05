<?
$form_settings = $form['form_settings'] ? $form['form_settings']->getArrayCopy() : array();
?>

<textarea name="form_settings[blocks][<?= htmlReady($block_id) ?>][elements][<?= htmlReady($element_id) ?>][sql]" placeholder="1=Wert 1
2=Wert 2
oder SELECT-Anweisung"><?= htmlReady($form_settings['blocks'][$block_id]['elements'][$element_id]['sql']) ?></textarea>

