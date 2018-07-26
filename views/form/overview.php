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