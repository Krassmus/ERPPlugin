<? $overview_settings = $form['overview_settings'] ? $form['overview_settings']->getArrayCopy() : array() ?>
<? $form_settings = $form['form_settings'] ? $form['form_settings']->getArrayCopy() : array() ?>
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
                    <td>
                        <?
                        $mapped_value = null;
                        foreach ((array) $form_settings['blocks'] as $block_id => $block_data) {
                            foreach ((array) $block_data['elements'] as $element_id => $element_data) {
                                if ($element_data['field'] === $fieldname && $element_data['type']) {
                                    $class = $element_data['type'];
                                    $element_object = new $class($form, $block_id, $element_id);
                                    $mapped_value = $element_object->mapValue($item[$fieldname]);
                                    break 2;
                                }
                            }
                        } ?>
                        <?= htmlReady($mapped_value
                            ? (is_a($mapped_value, "Flexi_Template") ? $mapped_value->render() : $mapped_value)
                            : $item[$fieldname]) ?>
                    </td>
                <? endforeach ?>
                <td class="actions">
                    <a href="<?= PluginEngine::getLink($plugin, array(), "form/edit/".$form->getId()."/".$item->getId()) ?>" data-dialog>
                        <?= Icon::create("edit", "clickable")->asImg(20, array('class' => "text-bottom")) ?>
                    </a>
                    <? if ($form->allowedToDelete()) : ?>
                        <form action="<?= PluginEngine::getLink($plugin, array(), "form/delete/".$form->getId()."/".$item->getId()) ?>" style="border: none; display: inline;" method="post">
                            <button style="border: 0; background: none; cursor: pointer;" title="<?= _("Objekt löschen") ?>" onClick="return window.confirm('<?= _("Objekt wirklich löschen?") ?>');">
                                <?= Icon::create("trash", "clickable")->asImg(20) ?>
                            </button>
                        </form>
                    <? endif ?>
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