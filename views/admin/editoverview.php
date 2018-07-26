<form action="<?= PluginEngine::getLink($plugin, array(), "admin/editoverview/".$form->getId()) ?>"
      method="post"
      class="default">

    <fieldset>
        <legend>
            <?= _("Einstellungen der Übersicht") ?>
        </legend>

        <label>
            <?= _("Nach welcher Spalte soll sortiert werden?") ?>
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
                            <input type="checkbox" name="roles[]" value="<?= htmlReady($role->getRoleid()) ?>">
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
                            <input type="checkbox" name="roles[]" value="<?= htmlReady($role->getRoleid()) ?>">
                            <?= htmlReady($role->getRolename()) ?>
                        </label>
                    </li>
                <? endif ?>
            <? endforeach ?>
        </ul>
    </fieldset>



</form>