<?php

class ERPCheckboxFormElement implements ERPFormElement
{

    protected $form = null;

    static public function getName()
    {
        return _("Checkbox");
    }

    static function forDataType()
    {
        return array("integer", "tinyint", "int", "long", "double", "float");
    }

    static function forFieldNames()
    {
        return true;
    }

    public function __construct(ERPForm $form)
    {
        $this->form = $form;
    }

    public function getSettingsTemplate($block_id, $element_id)
    {
        return null;
    }

    public function getPreviewTemplate($block_id, $element_id)
    {
        $tf = new Flexi_TemplateFactory(__DIR__."/../../views");
        $template = $tf->open("elements/preview/checkbox.php");
        $template->form = $this->form;
        $template->block_id = $block_id;
        $template->element_id = $element_id;
        return $template;
    }

    public function getElement($block_id, $element_id, $name, $value, $readonly)
    {
        $tf = new Flexi_TemplateFactory(__DIR__."/../../views");
        $template = $tf->open("elements/formelement/checkbox.php");
        $template->form = $this->form;
        $template->block_id = $block_id;
        $template->element_id = $element_id;
        $template->name = $name;
        $template->value = $value;
        $template->readonly = $readonly;
        return $template;
    }

    public function mapValue($value)
    {
        return $value ? _("Ja") : _("Nein");
    }
}