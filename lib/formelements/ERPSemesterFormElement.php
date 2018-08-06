<?php

class ERPSemesterFormElement implements ERPFormElement
{

    protected $form = null;

    static public function getName()
    {
        return _("Semester");
    }

    static function forDataType()
    {
        return array("varchar");
    }

    static function forFieldNames()
    {
        return array("start_time", "semester_id");
    }

    public function __construct(ERPForm $form)
    {
        $this->form = $form;
    }

    public function getSettingsTemplate($block_id, $element_id)
    {
        $tf = new Flexi_TemplateFactory(__DIR__."/../../views");
        $template = $tf->open("elements/settings/semester.php");
        $template->block_id = $block_id;
        $template->element_id = $element_id;
        $template->form = $this->form;
        return $template;
    }

    public function getPreviewTemplate($block_id, $element_id)
    {
        $tf = new Flexi_TemplateFactory(__DIR__."/../../views");
        $template = $tf->open("elements/preview/semester.php");
        $template->form = $this->form;
        $template->block_id = $block_id;
        $template->element_id = $element_id;
        return $template;
    }

    public function getElement($block_id, $element_id, $name, $value, $readonly)
    {
        $tf = new Flexi_TemplateFactory(__DIR__."/../../views");
        $template = $tf->open("elements/formelement/semester.php");
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
        if (is_numeric($value)) {
            $semester = Semester::findByTimestamp($value);
        } else {
            $semester = Semester::find($value);
        }
        if ($semester) {
            return $semester['name'];
        }
    }
}