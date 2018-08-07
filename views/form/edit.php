<form action="<?= PluginEngine::getLink($plugin, array(), "form/edit/".$form->getId()."/".$item->getId()) ?>"
      class="default"
      method="post">
    <?
    $form_settings = $form->form_settings ? $form->form_settings->getArrayCopy() : array();
    $roles = RolePersistence::getAssignedRoles($GLOBALS['user']->id, true);
    $role_ids = array_keys($roles);
    ?>
    <? foreach ((array) $form_settings['blocks'] as $block_id => $block) : ?>
        <fieldset>
            <legend><?= htmlReady($block['name']) ?></legend>
            <? foreach ((array) $block['elements'] as $element_id => $element_data) : ?>
                <?
                if ($element_data['type']) {
                    $class = $element_data['type'];
                    $form_element = new $class($form, $block_id, $element_id);
                    $template = $form_element->getElement(
                        "data[".$element_data['field']."]",
                        $item[$element_data['field']],
                        !(in_array("all", (array) $element_data['edit_permissions'])
                            || $GLOBALS['perm']->have_perm("root")
                            || count(array_intersect($role_ids, (array) $element_data['edit_permissions'])) > 0)
                    );
                    echo $template->render();
                }
                ?>
            <? endforeach ?>
        </fieldset>
    <? endforeach ?>
    <div data-dialog-button>
        <?= \Studip\Button::create(_("Speichern")) ?>
    </div>
</form>
