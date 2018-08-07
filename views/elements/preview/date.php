<input type="text"
       name="form_settings[blocks][<?= htmlReady($block_id) ?>][elements][<?= htmlReady($element_id) ?>][label]"
       value="<?= $form['form_settings']['blocks'][$block_id]['elements'][$element_id]['label'] ?: _("Tragen Sie bitte was ein") ?>"
       class="label-input"
       required>
<input type="text"
       class="erp_datepicker"
       value="<?= date("d.m.Y") ?>">
<script>
    jQuery(function () {
        jQuery(".erp_datepicker:not(.hasDatepicker)").datepicker({
            "dateFormat": "dd.mm.yy"
        });
    });
</script>