STUDIP.ERP = {
    addNewBlock: function () {
        var newblock = jQuery(".block_template").clone();
        newblock.removeClass("block_template");
        var block_id = "b_" + Math.floor(Math.random() * 1000000);
        var block_ids = [];
        jQuery(".erp_editform form fieldset").each(function () {
            block_ids.push(jQuery(this).data("block_id"));
        });
        while (_.includes(block_ids, block_id)) {
            block_id = "b_" + Math.floor(Math.random() * 1000000);
        }
        newblock.data("block_id", block_id);
        newblock.find("legend input").val("Block " + (jQuery(".erp_editform form fieldset").length + 1));
        newblock.appendTo(".erp_editform form");

        return false;
    },
    addNewElement: function () {
        var block = jQuery(this).closest("fieldset");
        var element = jQuery('<label>Element <input type="text"></label>');
        element.insertBefore(block.find(".add_element"));
        return false;
    }
};

jQuery(function () {
    jQuery(document).on("click", ".erp_editform .add_block", STUDIP.ERP.addNewBlock);
    jQuery(document).on("click", ".erp_editform .add_element", STUDIP.ERP.addNewElement);
});
