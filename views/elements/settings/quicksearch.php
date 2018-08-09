<?
$form_settings = $form['form_settings'] ? $form['form_settings']->getArrayCopy() : array();
?>

<textarea name="form_settings[blocks][<?= htmlReady($block_id) ?>][elements][<?= htmlReady($element_id) ?>][sql]" placeholder="SELECT id, name FROM ..."><?= htmlReady($form_settings['blocks'][$block_id]['elements'][$element_id]['sql']) ?></textarea>

<textarea name="form_settings[blocks][<?= htmlReady($block_id) ?>][elements][<?= htmlReady($element_id) ?>][mapper]" placeholder="SELECT name FROM ..."><?= htmlReady($form_settings['blocks'][$block_id]['elements'][$element_id]['mapper']) ?></textarea>

