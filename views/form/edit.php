<form action="<?= PluginEngine::getLink($plugin, array(), "form/edit/".$form->getId()."/".$item->getId()) ?>"
      class="default"
      method="post">
    <? $form_settings = $form->form_settings ? $form->form_settings->getArrayCopy() : array() ?>
    <? foreach ((array) $form_settings['blocks'] as $block_id => $block) : ?>
        <fieldset>
            <legend><?= htmlReady($block['name']) ?></legend>
            <? foreach ((array) $block['elements'] as $element_id => $element_data) : ?>
                <?
                if ($element_data['type']) {
                    $class = $element_data['type'];
                    $form_element = new $class($form);
                    $template = $form_element->getElement($block_id, $element_id, "data[".$element_data['field']."]", $item[$element_data['field']]);
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