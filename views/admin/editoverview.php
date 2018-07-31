<? $overview_settings = $form['overview_settings'] ? $form['overview_settings']->getArrayCopy() : array() ?>
<form action="<?= PluginEngine::getLink($plugin, array(), "admin/editoverview/".$form->getId()) ?>"
      method="post"
      class="default">

    <fieldset>
        <legend>
            <?= _("Einstellungen der Übersicht") ?>
        </legend>

        <h3><?= _("Welche Felder sollen in der Tabelle angezeigt werden?") ?></h3>
        <ul class="clean">
            <? foreach ($fieldnames as $fieldname) : ?>
            <li>
                <label>
                    <input type="checkbox"
                           name="data[overview_settings][fields][]"
                           value="<?= htmlReady($fieldname) ?>"
                           onChange="jQuery(this).closest('li').find('.mapper').toggle(jQuery(this).is(':checked'));"
                           <?= in_array($fieldname, (array) $overview_settings['fields']) ? "checked" : "" ?>>
                    <?= htmlReady($fieldname) ?>
                </label>

                <!-- Noch Mapper ? -->

                <div class="mapper" style="<?= in_array($fieldname, (array) $overview_settings['fields']) ? "" : "display: none; " ?>">
                    <label>
                        <?= _("Beschriftung der Spalte") ?>
                        <input type="text" name="data[overview_settings][fielddata][<?= htmlReady($fieldname) ?>][title]" value="<?= htmlReady($overview_settings['fielddata'][$fieldname]['title'] ?: "") ?>">
                    </label>
                </div>
            </li>
            <? endforeach ?>
        </ul>

        <label>
            <?= _("Nach welcher Spalte soll sortiert werden?") ?>
            <select name="data[overview_settings][sort]">
                <? foreach ($fieldnames as $fieldname) : ?>
                    <option value="<?= htmlReady($fieldname) ?>"><?= htmlReady($fieldname) ?></option>
                <? endforeach ?>
            </select>
        </label>
    </fieldset>

    <fieldset>
        <legend>
            <?= _("Wer darf neue Objekte erstellen?") ?>
        </legend>
        <ul class="clean">
            <? $roles = $form->getRoles() ?>
            <? foreach (RolePersistence::getAllRoles() as $role) : ?>
                <? if ($role->getRoleid() > 1 && in_array($role->getRoleid(), $roles)) : ?>
                    <li>
                        <label>
                            <input type="checkbox" name="data[overview_settings][createroles][]" value="<?= htmlReady($role->getRoleid()) ?>">
                            <?= htmlReady($role->getRolename()) ?>
                        </label>
                    </li>
                <? endif ?>
            <? endforeach ?>
        </ul>
    </fieldset>

    <fieldset>
        <legend>
            <?= _("Wer darf Objekte löschen?") ?>
        </legend>
        <ul class="clean">
            <? $roles = $form->getRoles() ?>
            <? foreach (RolePersistence::getAllRoles() as $role) : ?>
                <? if ($role->getRoleid() > 1 && in_array($role->getRoleid(), $roles)) : ?>
                    <li>
                        <label>
                            <input type="checkbox" name="data[overview_settings][deleteroles][]" value="<?= htmlReady($role->getRoleid()) ?>">
                            <?= htmlReady($role->getRolename()) ?>
                        </label>
                    </li>
                <? endif ?>
            <? endforeach ?>
        </ul>
    </fieldset>

    <div data-dialog-button>
        <?= \Studip\Button::create(_("Speichern")) ?>
    </div>

</form>