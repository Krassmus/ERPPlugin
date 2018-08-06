<form action="<?= PluginEngine::getLink($plugin, array(), "admin/edit/".$form->getId()) ?>"
      class="default"
      method="post">
    <fieldset>
        <legend>
            <?= _("Basisdaten") ?>
        </legend>
        <label>
            <?= _("Name des Formulars") ?>
            <input type="text" name="data[name]" value="<?= htmlReady($form['name']) ?>">
        </label>

        <label>
            <?= _("Navigation") ?>
            <select name="data[navigation]">
                <option value="/start"<?= $form['navigation'] === "/start" ? " selected" : "" ?>><?= _("Startseite") ?></option>
                <option value="/"<?= $form['navigation'] === "/" ? " selected" : "" ?>><?= _("Top-Navigation") ?></option>
                <option value="/tools"<?= $form['navigation'] === "/tools" ? " selected" : "" ?>><?= _("Tools") ?></option>
            </select>
        </label>

        <label class="required">
            <? if (version_compare(phpversion(), "7.0", ">=")) : ?>
                <?= _("SORM-Klasse oder Tabellenname") ?>
            <? else : ?>
                <?= _("SORM-Klasse") ?>
            <? endif ?>
            <input type="text" name="data[sorm_class]" value="<?= htmlReady($form['sorm_class']) ?>" required>
        </label>

        <label>
            <div>
                <?= _("Icon") ?>
            </div>
            <select name="data[icon]" id="data_icon">
                <? foreach ($icons as $icon) : ?>
                    <option value="<?= htmlReady($icon) ?>"
                            data-icon="<?= Icon::create($icon, "clickable")->asImagePath() ?>"
                            <?= $icon === $form['icon'] ? " selected" : "" ?>>
                        <?= htmlReady($icon) ?>
                    </option>
                <? endforeach ?>
            </select>
            <script>
                jQuery(function () {
                    jQuery("#data_icon").select2({
                        templateResult: function (state) {
                            if (!state.id) {
                                return state.text;
                            }
                            return jQuery('<span><img style="vertical-align: text-bottom;" width="20" src="' + jQuery(state.element).data("icon") + '">' + state.text + '</span>');
                        }
                    });
                });
            </script>
        </label>
    </fieldset>

    <fieldset>
        <legend>
            <?= _("Zugewiesene Rollen") ?>
        </legend>
        <ul class="clean">
            <? $roles = $form->getRoles() ?>
            <? foreach (RolePersistence::getAllRoles() as $role) : ?>
            <? if ($role->getRoleid() > 1) : ?>
            <li>
                <label>
                    <input type="checkbox" name="roles[]" value="<?= htmlReady($role->getRoleid()) ?>"<?= in_array($role->getRoleid(), $roles) ? ' checked="checked"' : ''  ?>>
                    <?= htmlReady($role->getRolename()) ?>
                </label>
            </li>
            <? endif ?>
            <? endforeach ?>
        </ul>
    </fieldset>

    <fieldset>
        <legend><?= _("Relationen") ?></legend>
        <ul class="clean">
            <li>
                <label>
                    <?= _("Name der SORM-Klasse") ?>
                    <input type="text">
                </label>
                <label>
                    <?= _("ON-Statement") ?>
                    <textarea placeholder="seminar_user.Seminar_id = seminare.Seminar_id AND seminar_user.status = 'dozent'"></textarea>
                </label>
                <label>
                    <?= _("Menge der Einträge") ?>
                    <select name="">
                        <option value="has_many">
                            <?= _("Mehrere Einträge (1:n)") ?>
                        </option>
                        <option value="has_one">
                            <?= _("Einzelner Eintrag (1:1)") ?>
                        </option>
                    </select>
                </label>
            </li>
        </ul>
    </fieldset>

    <div data-dialog-button>
        <?= \Studip\Button::create(_("Speichern")) ?>
    </div>
</form>