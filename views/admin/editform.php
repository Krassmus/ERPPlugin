<div class="erp_form erp_editform">
    <form class="default">
        <fieldset data-block_id="b_1">
            <legend>
                <span class="header-options">
                    <a href="#" class="trash">
                        <?= Icon::create("trash", "clickable")->asImg(20, array('class' => "text-bottom")) ?>
                    </a>
                </span>
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
            <span class="header-options">
                <a href="#">
                    <?= Icon::create("trash", "clickable")->asImg(20, array('class' => "text-bottom")) ?>
                </a>
            </span>
            <input type="text">
        </legend>

        <a class="add_element" href="#">
            <?= Icon::create("add", "clickable")->asImg(20) ?>
            <?= _("Element hinzufügen") ?>
        </a>
    </fieldset>

    <div class="element element_template">
        <div class="element_input">
            <label>
                <?= _("Label-Text") ?>
                <input type="text" placeholder="Bitte eingeben ...">
            </label>
        </div>
        <div class="element_controls">
            <label>
                <select name="">
                    <option value=""><?= _("Tabellenfeld") ?></option>
                    <? foreach ($form->getTableFields() as $field) : ?>
                        <option value="<?= htmlReady($field) ?>">
                            <?= htmlReady($field) ?>
                        </option>
                    <? endforeach ?>
                </select>
            </label>
            <label>

                <select name="">
                    <option value=""><?= _("Formularelement") ?></option>
                    <option value="text"><?= _("Textzeile") ?></option>
                    <option value="textarea"><?= _("Freitext") ?></option>
                    <option value="checkbox"><?= _("Checkbox") ?></option>
                </select>
            </label>
        </div>
        <div class="actions">
            <a href="#" class="element_toggler">
                <?= Icon::create("admin", "inactive")->asImg(20, array('class' => "text-bottom toggle_inactive")) ?>
                <?= Icon::create("admin+add", "clickable")->asImg(20, array('class' => "text-bottom toggle_active")) ?>
            </a>
            <a href="#" class="element_remover">
                <?= Icon::create("trash", "clickable")->asImg(20, array('class' => "text-bottom")) ?>
            </a>
        </div>
    </div>




    <a class="add_block" href="#">
        <?= Icon::create("add", "clickable")->asImg(25) ?>
        <?= _("Block hinzufügen") ?>
    </a>
</div>