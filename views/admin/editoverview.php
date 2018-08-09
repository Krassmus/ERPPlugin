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
                           name="overview_settings[fields][]"
                           value="<?= htmlReady($fieldname) ?>"
                           onChange="jQuery(this).closest('li').find('.mapper').toggle(jQuery(this).is(':checked'));"
                           <?= in_array($fieldname, (array) $overview_settings['fields']) ? "checked" : "" ?>>
                    <?= htmlReady($fieldname) ?>
                </label>

                <!-- Noch Mapper ? -->

                <div class="mapper" style="<?= in_array($fieldname, (array) $overview_settings['fields']) ? "" : "display: none; " ?>">
                    <label>
                        <?= _("Beschriftung der Spalte") ?>
                        <input type="text" name="overview_settings[fielddata][<?= htmlReady($fieldname) ?>][title]" value="<?= htmlReady($overview_settings['fielddata'][$fieldname]['title'] ?: "") ?>">
                    </label>
                </div>
            </li>
            <? endforeach ?>
        </ul>

        <label>
            <?= _("Nach welcher Spalte soll sortiert werden?") ?>
            <select name="overview_settings[sort]">
                <? foreach ($fieldnames as $fieldname) : ?>
                    <option value="<?= htmlReady($fieldname) ?>"<?= $fieldname == $overview_settings['sort'] ? " selected" : "" ?>>
                        <?= htmlReady($fieldname) ?>
                    </option>
                <? endforeach ?>
            </select>
        </label>
        <label>
            <?= _("Wie soll sortiert werden?") ?>
            <select name="overview_settings[sort_desc]">
                <option value="0">
                    <?= _("Aufsteigend") ?>
                </option>
                <option value="1"<?= $overview_settings['sort_desc'] > 0 ? " selected" : "" ?>>
                    <?= _("Absteigend") ?>
                </option>
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
                            <input type="checkbox" name="overview_settings[createroles][]" value="<?= htmlReady($role->getRoleid()) ?>">
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
                            <input type="checkbox" name="overview_settings[deleteroles][]" value="<?= htmlReady($role->getRoleid()) ?>">
                            <?= htmlReady($role->getRolename()) ?>
                        </label>
                    </li>
                <? endif ?>
            <? endforeach ?>
        </ul>
    </fieldset>

    <fieldset>
        <legend>
            <?= _("Filter") ?>
        </legend>

        <ul class="clean">
            <? foreach ((array) $overview_settings['filters'] as $filter_id => $filter_data) : ?>
                <?= $this->render_partial("admin/_filter", array(
                    'filter_id' => $filter_id,
                    'form' => $form,
                    'filter_classes' => $filter_classes
                )) ?>
            <? endforeach ?>
        </ul>

        <a href="">
            <?= Icon::create("add", "clickable")->asImg(20, array('class' => "text-bottom")) ?>
            <?= _("Filter hinzufügen") ?>
        </a>

    </fieldset>

    <div data-dialog-button>
        <?= \Studip\Button::create(_("Speichern")) ?>
    </div>

</form>

<!-- Filter template -->
<?= $this->render_partial("admin/_filter", array(
    'filter_id' => null,
    'form' => $form,
    'filter_classes' => $filter_classes
)) ?>