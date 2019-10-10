<?php
$isTemplate = !$filter_id;
$filter_id || $filter_id = ":filter_id";
$overview_settings = $form['overview_settings'] ? $form['overview_settings']->getArrayCopy() : array();
$filter_data || $filter_data = $overview_settings['filters'][$filter_id];
?>
<li data-filter_id="<?= htmlReady($filter_id) ?>" class="filter <?= $isTemplate ? "filter_template" : "" ?>">
    <select name="overview_settings[filters][<?= htmlReady($filter_id) ?>][type]">
        <option></option>
        <? foreach ($filter_classes as $class) : ?>
        <option value="<?= htmlReady($class) ?>"<?= $filter_data['type'] === $class ? " selected" : "" ?>>
            <?= htmlReady($class::getName()) ?>
        </option>
        <? endforeach ?>
    </select>
    <select name="overview_settings[filters][<?= htmlReady($filter_id) ?>][permissions][]"
            multiple
            class="multiple"
            aria-label="<?= _("Welche Rollen sollen den Filter bekommen?") ?>"
            style="width: 100%; max-width: 48em;">
        <option value="all"<?= in_array("all", (array) $filter_data['permissions']) || $filter_data['permissions'] === null ? " selected" : "" ?>><?= _("Alle") ?></option>
        <? $roles = $form->getRoles() ?>
        <? foreach (RolePersistence::getAllRoles() as $role) : ?>
            <? if ($role->getRoleid() > 1 && in_array($role->getRoleid(), $roles)) : ?>
                <option value="<?= htmlReady($role->getRoleid()) ?>"<?= in_array($role->getRoleid(), (array) $filter_data['permissions']) ? " selected" : "" ?>>
                    <?= htmlReady($role->getRolename()) ?>
                </option>
            <? endif ?>
        <? endforeach ?>
    </select>
    <div class="filter_settings">
        <? if ($filter_data['type']) {
            $filter_object = new $filter_data['type']($form, $filter_id);
            $template = $filter_object->getSettingsTemplate();
            if ($template) {
                echo $template->render();
            }
        } ?>
    </div>
</li>