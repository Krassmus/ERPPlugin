<form action="<?= PluginEngine::getLink($plugin, array(), "form/edit/".$form->getId()."/") ?>"
      class="default"
      method="post">
    <? $form_settings = $form->form_settings ? $form->form_settings->getArrayCopy() : array() ?>
    <? foreach ((array) $form_settings['blocks'] as $block) : ?>
        <fieldset>
            <legend><?= htmlReady($block['legend']) ?></legend>
            test
        </fieldset>
    <? endforeach ?>
    <div data-dialog-button>
        <?= \Studip\Button::create(_("Speichern")) ?>
    </div>
</form>