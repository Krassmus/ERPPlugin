<?
$isTemplate = !$block_id;
$block_id || $block_id = ":block_id";
$element_id || $element_id = ":element_id";
$form_settings = $form['form_settings'] ? $form['form_settings']->getArrayCopy() : array();
$element_data || $element_data = $form_settings['blocks'][$block_id]['elements'][$element_id];
?>
<div class="element <?= $isTemplate ? "element_template" : ($element_data['show_controls'] ? "show_controls" : "") ?>">
    <input type="hidden"
           class="show_controls"
           name="form_settings[blocks][<?= htmlReady($block_id) ?>][elements][<?= htmlReady($element_id) ?>][show_controls]"
           value="<?= $isTemplate || $element_data['show_controls'] ? 1 : 0 ?>">
    <div class="element_input">
        <? if ($element_data['type']) {
            $form_element = new $element_data['type']($form, $block_id, $element_id);
            $template = $form_element->getPreviewTemplate();
            if ($template) {
                echo $template->render();
            }
        } ?>
    </div>
    <div class="element_controls">
        <select name="form_settings[blocks][<?= htmlReady($block_id) ?>][elements][<?= htmlReady($element_id) ?>][field]"
                aria-label="<?= _("Tabellenfeld auswählen") ?>"
                required>
            <option value=""><?= _("Tabellenfeld") ?></option>
            <? foreach ($form->getTableFields() as $field) : ?>
                <option value="<?= htmlReady($field) ?>"<?= $element_data['field'] === $field ? " selected" : "" ?>>
                    <?= htmlReady($field) ?>
                </option>
            <? endforeach ?>
        </select>
        <select name="form_settings[blocks][<?= htmlReady($block_id) ?>][elements][<?= htmlReady($element_id) ?>][type]"
                class="erp_form_element"
                aria-label="<?= _("Element-Typ auswählen") ?>"
                required>
            <option value=""><?= _("Element-Typ") ?></option>
            <? foreach ($form_element_classes as $form_element) : ?>
                <option value="<?= htmlReady($form_element) ?>"<?= $element_data['type'] === $form_element ? " selected" : "" ?>>
                    <?= htmlReady($form_element::getName()) ?>
                </option>
            <? endforeach ?>
        </select>
        <select name="form_settings[blocks][<?= htmlReady($block_id) ?>][elements][<?= htmlReady($element_id) ?>][edit_permissions][]"
                multiple
                class="multiple"
                aria-label="<?= _("Welche Rollen dürfen das Formularelement bearbeiten?") ?>"
                style="width: 100%; max-width: 48em;">
            <option value="all"<?= in_array("all", (array) $element_data['edit_permissions']) || $element_data['edit_permissions'] === null ? " selected" : "" ?>><?= _("Alle") ?></option>
            <? $roles = $form->getRoles() ?>
            <? foreach (RolePersistence::getAllRoles() as $role) : ?>
                <? if ($role->getRoleid() > 1 && in_array($role->getRoleid(), $roles)) : ?>
                    <option value="<?= htmlReady($role->getRoleid()) ?>"<?= in_array($role->getRoleid(), (array) $element_data['edit_permissions']) ? " selected" : "" ?>>
                        <?= htmlReady($role->getRolename()) ?>
                    </option>
                <? endif ?>
            <? endforeach ?>
        </select>
        <div class="form_type_settings">
            <? if ($element_data['type']) {
                $form_element = new $element_data['type']($form, $block_id, $element_id);
                $template = $form_element->getSettingsTemplate();
                if ($template) {
                    echo $template->render();
                }
            } ?>
        </div>
    </div>
    <div class="actions">
        <a href="#" class="drag">
            <?= Assets::img("anfasser_24.png", array('class' => "text-bottom")) ?>
        </a>
        <a href="#" class="element_toggler">
            <?= Icon::create("admin", "inactive")->asImg(20, array('class' => "text-bottom toggle_inactive")) ?>
            <?= Icon::create("admin+add", "clickable")->asImg(20, array('class' => "text-bottom toggle_active")) ?>
        </a>
        <a href="#" class="element_remover">
            <?= Icon::create("trash", "clickable")->asImg(20, array('class' => "text-bottom")) ?>
        </a>
    </div>
</div>