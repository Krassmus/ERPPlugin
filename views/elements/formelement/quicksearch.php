<? $form_settings = $form->form_settings ? $form->form_settings->getArrayCopy() : array() ?>
<label>
    <?= htmlReady($form_settings['blocks'][$block_id]['elements'][$element_id]['label']) ?>
    <?= QuickSearch::get($name, $search)->defaultValue($value, $value_display)->noSelectbox()->render() ?>
    <!-- Doesn't work because the name has [] in it, which makes a bad ID attribute for quicksearch -->
</label>
