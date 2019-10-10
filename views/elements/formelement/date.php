<? $form_settings = $form->form_settings ? $form->form_settings->getArrayCopy() : array() ?>
<label>
    <?= htmlReady($form_settings['blocks'][$block_id]['elements'][$element_id]['label']) ?>
    <input type="text"
           <? if (!$readonly) : ?>
           name="<?= htmlReady($name) ?>"
           class="erp_datepicker"
           <? else : ?>
           readonly disabled
           <? endif ?>
           placeholder="<?= htmlReady($form['form_settings']['blocks'][$block_id]['elements'][$element_id]['placeholder']) ?>"
           value="<?= date("d.m.Y", $value) ?>">
</label>
<script>
    jQuery(function () {
        jQuery(".erp_datepicker:not(.hasDatepicker)").datepicker({
            "dateFormat": "dd.mm.yy"
        });
    });
</script>