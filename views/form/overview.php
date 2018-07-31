<? $overview_settings = $form['overview_settings'] ? $form['overview_settings']->getArrayCopy() : array() ?>
<table class="default">
    <caption>
        <?= htmlReady($form['name']) ?>
    </caption>
    <thead>
        <tr>
            <? foreach ((array) $overview_settings['fields'] as $fieldname) : ?>
            <th>
                <?= htmlReady($overview_settings['fielddata'][$fieldname]['title'] ?: $fieldname) ?>
            </th>
            <? endforeach ?>
            <th class="actions"><?= _("Aktionen") ?></th>
        </tr>
    </thead>
    <tbody>
        <? if (count($items)) : ?>
        <? foreach ($items as $item) : ?>
            <tr>
                <? foreach ((array) $overview_settings['fields'] as $fieldname) : ?>
                    <td><?= htmlReady($item[$fieldname]) ?></td>
                <? endforeach ?>
                <td class="actions">
                    <a href="<?= PluginEngine::getLink($plugin, array(), "form/edit/".$form->getId()."/".$item->getId()) ?>" data-dialog>
                        <?= Icon::create("edit", "clickable")->asImg(20, array('class' => "text-bottom")) ?>
                    </a>
                </td>
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