<?php

class ERPDateFormElement implements ERPFormElement
{

    protected $form = null;
    protected $block_id = null;
    protected $element_id = null;

    static public function getName()
    {
        return _("Datum");
    }

    static function forDataType()
    {
        return array("integer", "int");
    }

    static function forFieldNames()
    {
        return true;
    }

    public function __construct(ERPForm $form, $block_id, $element_id)
    {
        $this->form = $form;
        $this->block_id = $block_id;
        $this->element_id = $element_id;
    }

    public function getSettingsTemplate()
    {
        return null;
    }

    public function getPreviewTemplate()
    {
        $tf = new Flexi_TemplateFactory(__DIR__."/../../views");
        $template = $tf->open("elements/preview/date.php");
        $template->form = $this->form;
        $template->block_id = $this->block_id;
        $template->element_id = $this->element_id;
        return $template;
    }

    public function getElement($name, $value, $readonly)
    {
        $tf = new Flexi_TemplateFactory(__DIR__."/../../views");
        $template = $tf->open("elements/formelement/date.php");
        $template->form = $this->form;
        $template->block_id = $this->block_id;
        $template->element_id = $this->element_id;
        $template->name = $name;
        $template->value = $value;
        $template->readonly = $readonly;
        return $template;
    }

    public function mapValue($value)
    {
        return date("d.m.Y", $value);
    }

    public function mapBeforeStoring($value)
    {
        return strtotime($value);
    }

    public function hookAfterStoring($newvalue, $oldvalue)
    {

    }
}