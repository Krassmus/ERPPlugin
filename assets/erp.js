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
        newblock.find("legend input").attr("name", "form_settings[blocks][" + block_id + "][name]");
        newblock.appendTo(".erp_editform form");

        return false;
    },
    addNewElement: function () {
        var block = jQuery(this).closest("fieldset");
        var element = jQuery(".erp_editform .element_template").clone();
        element.removeClass("element_template");
        element.addClass("show_controls");

        var element_id = "e_" + Math.floor(Math.random() * 1000000);
        var element_ids = [];
        jQuery(".erp_editform form .element").each(function () {
            element_ids.push(jQuery(this).data("element_id"));
        });
        while (_.includes(element_ids, element_id)) {
            element_id = "e_" + Math.floor(Math.random() * 1000000);
        }
        element.data("element_id", element_id);
        element.find(".element_controls select, input").each(function () {
            if (jQuery(this).attr("name")) {
                jQuery(this).attr("name", jQuery(this).attr("name").replace(":block_id", block.data("block_id")));
                jQuery(this).attr("name", jQuery(this).attr("name").replace(":element_id", element_id));
            }
        });

        element.appendTo(block.find(".elements_sortable"));
        return false;
    },
    removeBlock: function () {
        var element = jQuery(this).closest("fieldset");
        STUDIP.Dialog.confirm("Wirklich löschen?", function () {
            element.fadeOut(300, function () {
                element.remove();
            });
        });
        return false;
    },
    removeElement: function () {
        var element = jQuery(this).closest(".element");
        STUDIP.Dialog.confirm("Wirklich löschen?", function () {
            element.fadeOut(300, function () {
                element.remove();
            });
        });
        return false;
    },
    toggleElementControls: function () {
        var element = jQuery(this).closest(".element");
        element.toggleClass("show_controls");
        element.find("input.show_controls").val(element.hasClass("show_controls") ? 1 : 0);
        return false;
    },
    selectFormElement: function () {
        var element = jQuery(this).closest(".element");
        var block_id = jQuery(this).closest("fieldset").data("block_id");
        var element_id = jQuery(this).closest(".element").data("element_id");
        var form_id = jQuery(this).closest("form").data("form_id");
        jQuery.ajax({
            "url": STUDIP.URLHelper.getURL("plugins.php/erpplugin/admin/get_form_settings"),
            "data": {
                "erp_form_element": jQuery(this).val(),
                'block_id': block_id,
                'element_id': element_id,
                'form_id': form_id
            },
            "success": function (json) {
                jQuery(element).find(".form_type_settings").html(json.settings ? json.settings : "");
                jQuery(element).find(".element_input").html(json.preview ? json.preview : "");
            }
        });
    },
    addNewFilter: function () {
        var newfilter = jQuery(".filter_template").clone();
        newfilter.removeClass("filter_template");
        var filter_id = "f_" + Math.floor(Math.random() * 1000000);
        var filter_ids = [];
        jQuery(".erp_editoverview form .filter").each(function () {
            filter_ids.push(jQuery(this).data("filter_id"));
        });
        while (_.includes(filter_ids, filter_id)) {
            filter_id = "f_" + Math.floor(Math.random() * 1000000);
        }
        newfilter.data("filter_id", filter_id);
        newfilter.find("select, input, textarea").each(function () {
            if (jQuery(this).attr("name")) {
                jQuery(this).attr("name", jQuery(this).attr("name").replace(":filter_id", filter_id));
            }
        });
        newfilter.appendTo(".erp_editoverview form .filters");

        return false;
    },

};

jQuery(function () {
    jQuery(document).on("click", ".erp_editform .add_block", STUDIP.ERP.addNewBlock);
    jQuery(document).on("click", ".erp_editform .add_element", STUDIP.ERP.addNewElement);
    jQuery(document).on("click", ".erp_editform legend .header-options a.trash", STUDIP.ERP.removeBlock);
    jQuery(document).on("click", ".erp_editform .element .element_remover", STUDIP.ERP.removeElement);
    jQuery(document).on("click", ".erp_editform .element .element_toggler", STUDIP.ERP.toggleElementControls);
    jQuery(document).on("click", ".erp_editform .erp_form_element", STUDIP.ERP.selectFormElement);
    jQuery(document).on("click", ".erp_editoverview .add_filter", STUDIP.ERP.addNewFilter);
});
