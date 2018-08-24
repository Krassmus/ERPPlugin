<? $form_settings = (array) ($form['form_settings'] ? $form['form_settings']->getArrayCopy() : array()) ?>
<? $roles = $form->getRoles() ?>
<div class="erp_form erp_editform">
    <form class="default"
          action="<?= PluginEngine::getLink($plugin, array(), "admin/editform/".$form->getId()) ?>"
          method="post"
          data-form_id="<?= htmlReady($form->getId()) ?>">
        <? if (!$form_settings['blocks']) : ?>
            <fieldset data-block_id="b_1">
                <legend>
                    <span class="header-options">
                        <a href="#" class="trash">
                            <?= Icon::create("trash", "clickable")->asImg(20, array('class' => "text-bottom")) ?>
                        </a>
                    </span>
                    <input type="text" name="form_settings[blocks][b_1][name]" value="Block 1">
                </legend>
                <a class="add_element" href="#">
                    <?= Icon::create("add", "clickable")->asImg(20) ?>
                    <?= _("Element hinzufügen") ?>
                </a>

                <div<?= count($roles) > 1 ? '' : ' style="display: none"' ?>>
                    <?= Icon::create("visibility-visible", "info")->asImg(20, array('class' => "text-bottom", 'title' => _("Wer darf diesen Block sehen?"))) ?>
                    <select name="form_settings[blocks][b_1][visibility][]"
                            class="visibility" multiple>
                        <option value="all" selected><?= _("Alle") ?></option>
                        <? foreach (RolePersistence::getAllRoles() as $role) : ?>
                            <? if ($role->getRoleid() > 1 && in_array($role->getRoleid(), $roles)) : ?>
                                <option value="<?= htmlReady($role->getRoleid()) ?>">
                                    <?= htmlReady($role->getRolename()) ?>
                                </option>
                            <? endif ?>
                        <? endforeach ?>
                    </select>
                </div>
            </fieldset>
        <? else : ?>
            <? foreach ((array) $form_settings['blocks'] as $block_id => $blockdata) : ?>
                <fieldset data-block_id="<?= htmlReady($block_id) ?>">
                    <legend>
                        <span class="header-options">
                            <a href="#" class="trash">
                                <?= Icon::create("trash", "clickable")->asImg(20, array('class' => "text-bottom")) ?>
                            </a>
                        </span>
                        <input type="text"
                               name="form_settings[blocks][<?= htmlReady($block_id) ?>][name]"
                               value="<?= htmlReady($blockdata['name']) ?>">
                    </legend>

                    <div class="elements_sortable">
                    <? foreach ((array) $blockdata['elements'] as $element_id => $element_data) : ?>
                        <?= $this->render_partial("form/_element", array(
                                'block_id' => $block_id,
                                'element_id' => $element_id,
                                'form' => $form,
                                'form_element_classes' => $form_element_classes)
                        ) ?>
                    <? endforeach ?>
                    </div>

                    <a class="add_element" href="#">
                        <?= Icon::create("add", "clickable")->asImg(20) ?>
                        <?= _("Element hinzufügen") ?>
                    </a>

                    <div<?= count($roles) > 1 ? '' : ' style="display: none"' ?>>
                        <?= Icon::create("visibility-visible", "info")->asImg(20, array('class' => "text-bottom", 'title' => _("Wer darf diesen Block sehen?"))) ?>
                        <select name="form_settings[blocks][<?= htmlReady($block_id) ?>][visibility][]"
                                class="visibility" multiple>
                            <option value="all"<?= in_array("all", (array) $form_settings['blocks'][$block_id]['visibility']) || $form_settings['blocks'][$block_id]['visibility'] === null ? " selected" : "" ?>><?= _("Alle") ?></option>
                            <? foreach (RolePersistence::getAllRoles() as $role) : ?>
                                <? if ($role->getRoleid() > 1 && in_array($role->getRoleid(), $roles)) : ?>
                                    <option value="<?= htmlReady($role->getRoleid()) ?>"<?= in_array($role->getRoleid(), (array) $form_settings['blocks'][$block_id]['visibility']) ? " selected" : "" ?>>
                                        <?= htmlReady($role->getRolename()) ?>
                                    </option>
                                <? endif ?>
                            <? endforeach ?>
                        </select>
                    </div>
                </fieldset>
            <? endforeach ?>
        <? endif ?>

        <div data-dialog-button>
            <?= \Studip\Button::create(_("Speichern")) ?>
        </div>
    </form>

    <!-- Templates -->

    <fieldset class="block_template">
        <legend>
            <span class="header-options">
                <a href="#" class="trash">
                    <?= Icon::create("trash", "clickable")->asImg(20, array('class' => "text-bottom")) ?>
                </a>
            </span>
            <input type="text">
        </legend>

        <div class="elements_sortable"></div>

        <a class="add_element" href="#">
            <?= Icon::create("add", "clickable")->asImg(20) ?>
            <?= _("Element hinzufügen") ?>
        </a>

        <div<?= count($roles) > 1 ? '' : ' style="display: none"' ?>>
            <?= Icon::create("visibility-visible", "info")->asImg(20, array('class' => "text-bottom", 'title' => _("Wer darf diesen Block sehen?"))) ?>
            <select class="visibility" multiple>
                <option value="all" selected><?= _("Alle") ?></option>
                <? foreach (RolePersistence::getAllRoles() as $role) : ?>
                    <? if ($role->getRoleid() > 1 && in_array($role->getRoleid(), $roles)) : ?>
                        <option value="<?= htmlReady($role->getRoleid()) ?>">
                            <?= htmlReady($role->getRolename()) ?>
                        </option>
                    <? endif ?>
                <? endforeach ?>
            </select>
        </div>
    </fieldset>

    <!-- Form element template -->
    <?= $this->render_partial("form/_element", array(
            'block_id' => null,
            'element_id' => null,
            'form' => $form,
            'form_element_classes' => $form_element_classes)
    ) ?>

    <a class="add_block" href="#">
        <?= Icon::create("add", "clickable")->asImg(25) ?>
        <?= _("Block hinzufügen") ?>
    </a>
</div>
<script>
    jQuery(function () {
        jQuery(".erp_editform .elements_sortable").sortable({
            "handle": ".drag",
            "axis": "y"
        });
        jQuery("select.multiple, select.visibility").select2({width: 'resolve'});
    })
</script>
