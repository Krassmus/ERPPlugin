<?
$form_settings = $form['form_settings'] ? $form['form_settings']->getArrayCopy() : array();
?>
<label>
    <input type="hidden"
           name="form_settings[blocks][<?= htmlReady($block_id) ?>][elements][<?= htmlReady($element_id) ?>][notify]"
           value="0">
    <input type="checkbox"
           name="form_settings[blocks][<?= htmlReady($block_id) ?>][elements][<?= htmlReady($element_id) ?>][notify]"
           value="1"
            <?= $form_settings['blocks'][$block_id]['elements'][$element_id]['notify'] ? "checked" : "" ?>>
    <?= _("Nutzer benachrichtigen, wenn sie zugewiesen werden?") ?>
</label>


