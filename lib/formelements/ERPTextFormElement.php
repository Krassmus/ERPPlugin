<?php

class ERPTextFormElement implements ERPFormElement
{

    protected $form = null;

    static function forDataType()
    {
        return array("varchar", "text");
    }

    static function forFieldNames()
    {
        return true;
    }

    public function __construct(ERPForm $form)
    {
        $this->form = $form;
    }

    public function getSettingsTemplate()
    {
        return null;
    }

    public function getPreviewTemplate($block_id, $element_id)
    {
        $tf = new Flexi_TemplateFactory(__DIR__."/../../views");
        $template = $tf->open("elements/preview/text.php");
        $template->form = $this->form;
        $template->block_id = $block_id;
        $template->element_id = $element_id;
        return $template;
    }

    public function getElement($name, $value)
    {
        $tf = new Flexi_TemplateFactory(__DIR__."/../../views");
        $template = $tf->open("elements/formelement/text.php");
        return $template;
    }
}