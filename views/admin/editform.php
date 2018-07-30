<div class="erp_form erp_editform">
    <form class="default">
        <fieldset data-block_id="b_1">
            <legend>
                <input type="text" value="Block 1">
            </legend>
            <a class="add_element" href="#">
                <?= Icon::create("add", "clickable")->asImg(20) ?>
                <?= _("Element hinzufügen") ?>
            </a>
        </fieldset>
    </form>

    <!-- Templates -->

    <fieldset class="block_template">
        <legend>
            <input type="text">
        </legend>

        <a class="add_element" href="#">
            <?= Icon::create("add", "clickable")->asImg(20) ?>
            <?= _("Element hinzufügen") ?>
        </a>
    </fieldset>


    <a class="add_block" href="#">
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
</div>