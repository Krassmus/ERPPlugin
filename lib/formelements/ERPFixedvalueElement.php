<?php

class ERPFixedvalueElement implements ERPFormElement
{

    protected $form = null;
    protected $block_id = null;
    protected $element_id = null;

    static public function getName()
    {
        return _("Fester Wert");
    }

    static function forDataType()
    {
        return array("varchar", "text", "int", "integer");
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
        $tf = new Flexi_TemplateFactory(__DIR__."/../../views");
        $template = $tf->open("elements/settings/fixedvalue.php");
        $template->form = $this->form;
        $template->block_id = $this->block_id;
        $template->element_id = $this->element_id;
        return $template;
    }

    public function getPreviewTemplate()
    {
        $tf = new Flexi_TemplateFactory(__DIR__."/../../views");
        $template = $tf->open("elements/preview/fixedvalue.php");
        $template->form = $this->form;
        $template->block_id = $this->block_id;
        $template->element_id = $this->element_id;
        return $template;
    }

    public function getElement($name, $value, $readonly)
    {
        return null;
    }

    public function mapValue($value)
    {
        return $this->form['blocks'][$this->block_id]['elements'][$this->element_id]['value'];
    }

    public function mapBeforeStoring($value)
    {
        return $value;
    }

    public function hookAfterStoring($newvalue, $oldvalue, $item)
    {

    }
}