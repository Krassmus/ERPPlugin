<table class="default">
    <caption>
        <?= _("Formulare") ?>
    </caption>
    <thead>
        <tr>
            <th><?= _("Name") ?></th>
            <th><?= _("Klasse") ?></th>
            <th><?= _("Rollen") ?></th>
            <th class="actions"><?= _("Aktionen") ?></th>
        </tr>
    </thead>
    <tbody>
        <? if (count($forms)) : ?>
            <? foreach ($forms as $form) : ?>
                <tr id="form_<?= htmlReady($form->getId()) ?>">
                    <td>
                        <a href="<?= PluginEngine::getLink($plugin, array(), "form/overview/".$form->getId()) ?>">
                            <?= Icon::create($form['icon'], "clickable")->asImg(20, array('class' => "text-bottom")) ?>
                            <?= htmlReady($form['name']) ?>
                        </a>
                    </td>
                    <td>
                        <? if (!class_exists($form['sorm_class'])) : ?>
                            <?= Icon::create("exclaim-circle", "status-red")->asImg(20, array('class' => "text-bottom", 'title' => _("SORM-Klasse existiert nicht!"))) ?>
                        <? endif ?>
                        <?= htmlReady($form['sorm_class']) ?>
                    </td>
                    <td>
                        <ul class="clean">
                        <? $roles = $form->getRoles() ?>
                        <? foreach (RolePersistence::getAllRoles() as $role) : ?>
                            <? if ($role->getRoleid() > 1 && in_array($role->getRoleid(), $roles)) : ?>
                                <li>
                                    <?= htmlReady($role->getRolename()) ?>
                                </li>
                            <? endif ?>
                        <? endforeach ?>
                        </ul>
                    </td>
                    <td class="actions">
                        <a href="<?= PluginEngine::getLink($plugin, array(), "admin/edit/".$form->getId()) ?>" data-dialog title="<?= _("Grunddaten bearbeiten") ?>">
                            <?= Icon::create("edit", "clickable")->asImg(20) ?>
                        </a>
                        <a href="<?= PluginEngine::getLink($plugin, array(), "admin/editoverview/".$form->getId()) ?>" data-dialog title="<?= _("Übersichtsseite bearbeiten") ?>">
                            <?= Icon::create("archive3", "clickable")->asImg(20) ?>
                        </a>
                        <a href="<?= PluginEngine::getLink($plugin, array(), "admin/editform/".$form->getId()) ?>" data-dialog title="<?= _("Formularfelder bearbeiten") ?>">
                            <?= Icon::create("assessment", "clickable")->asImg(20) ?>
                        </a>
                        <form action="<?= PluginEngine::getLink($plugin, array(), "admin/delete/".$form->getId()) ?>" style="border: none; display: inline;" method="post">
                            <button style="border: 0; background: none; cursor: pointer;" title="<?= _("Formular löschen") ?>" onClick="return window.confirm('<?= _("Formular wirklich löschen?") ?>');">
                                <?= Icon::create("trash", "clickable")->asImg(20) ?>
                            </button>
                        </form>
                    </td>
                </tr>
            <? endforeach ?>
        <? else : ?>
            <tr>
                <td colspan="100">
                    <?= _("Noch keine Formulare definiert") ?>
                </td>
            </tr>
        <? endif ?>
    </tbody>
</table>

<?

$actions = new ActionsWidget();
$actions->addLink(
    _("Neues Formular erstellen"),
    PluginEngine::getURL($plugin, array(), "admin/edit"),
    Icon::create("add", "clickable"),
    array('data-dialog' => 1)
);
Sidebar::Get()->addWidget($actions);