<table class="default">
    <caption>
        <?= htmlReady($form['name']) ?>
    </caption>
    <thead>
        <tr>
            <th></th>
            <th class="actions"><?= _("Aktionen") ?></th>
        </tr>
    </thead>
    <tbody>
        <? if (count($items)) : ?>
        <? foreach ($items as $item) : ?>
            <tr>
                <td></td>
                <td>action</td>
            </tr>
        <? endforeach ?>
        <? else : ?>
            <tr>
                <td colspan="1000">
                    <?= _("Keine Objekte bisher") ?>
                </td>
            </tr>
        <? endif ?>
    </tbody>
</table>

<?

$actions = new ActionsWidget();
if ($form->allowedToCreate()) {
    $actions->addLink(
        _("Neues Objekt erstellen"),
        PluginEngine::getURL($plugin, array(), "form/edit/".$form->getId()),
        Icon::create("add", "clickable"),
        array('data-dialog' => 1)
    );
}
Sidebar::Get()->addWidget($actions);