<?php

class ERPSemesterFormElement implements ERPFormElement
{

    protected $form = null;
    protected $block_id = null;
    protected $element_id = null;

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

    public function __construct(ERPForm $form, $block_id, $element_id)
    {
        $this->form = $form;
        $this->block_id = $block_id;
        $this->element_id = $element_id;
    }

    public function getSettingsTemplate()
    {
        $tf = new Flexi_TemplateFactory(__DIR__."/../../views");
        $template = $tf->open("elements/settings/semester.php");
        $template->block_id = $this->block_id;
        $template->element_id = $this->element_id;
        $template->form = $this->form;
        return $template;
    }

    public function getPreviewTemplate()
    {
        $tf = new Flexi_TemplateFactory(__DIR__."/../../views");
        $template = $tf->open("elements/preview/semester.php");
        $template->form = $this->form;
        $template->block_id = $this->block_id;
        $template->element_id = $this->element_id;
        return $template;
    }

    public function getElement($name, $value, $readonly)
    {
        $tf = new Flexi_TemplateFactory(__DIR__."/../../views");
        $template = $tf->open("elements/formelement/semester.php");
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
        if (is_numeric($value)) {
            $semester = Semester::findByTimestamp($value);
        } else {
            $semester = Semester::find($value);
        }
        if ($semester) {
            return $semester['name'];
        }
    }

    public function mapBeforeStoring($value)
    {
        return $value;
    }

    public function hookAfterStoring($newvalue, $oldvalue, $item)
    {

    }
}