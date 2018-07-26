<form class="default">
    <fieldset data-block_id="4">
        <legend>
            <input type="text" style="border: none; background-color: transparent;" value="Block 1">
        </legend>

        <a style="padding: 5px; display: flex; align-items: center;" href="#">
            <?= Icon::create("add", "clickable")->asImg(20) ?>
            <?= _("Element hinzufügen") ?>
        </a>
    </fieldset>
</form>


<a style="border: 1px solid #d0d7e3; background-color: #e7ebf1; padding: 10px; display: flex; align-items: center; justify-content: center;" href="#">
    <?= Icon::create("add", "clickable")->asImg(25) ?>
    <?= _("Block hinzufügen") ?>
</a>

<h2><?= _("Tabellenfelder") ?></h2>
<ul>
    <? foreach ($form->getTableFields() as $field) : ?>
    <li>
        <?= htmlReady($field) ?>
    </li>
    <? endforeach ?>
</ul>