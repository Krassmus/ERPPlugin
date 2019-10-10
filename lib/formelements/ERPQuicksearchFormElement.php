<?php

class ERPQuicksearchFormElement implements ERPFormElement
{

    protected $form = null;
    protected $block_id = null;
    protected $element_id = null;

    static public function getName()
    {
        return _("Quicksearch (SQL)");
    }

    static function forDataType()
    {
        return array("varchar");
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
        $template = $tf->open("elements/settings/quicksearch.php");
        $template->form = $this->form;
        $template->block_id = $this->block_id;
        $template->element_id = $this->element_id;
        return $template;
    }

    public function getPreviewTemplate()
    {
        $tf = new Flexi_TemplateFactory(__DIR__."/../../views");
        $template = $tf->open("elements/preview/quicksearch.php");
        $template->form = $this->form;
        $template->block_id = $this->block_id;
        $template->element_id = $this->element_id;
        return $template;
    }

    public function getElement($name, $value, $readonly)
    {
        $tf = new Flexi_TemplateFactory(__DIR__."/../../views");
        $template = $tf->open("elements/formelement/quicksearch.php");
        $template->form = $this->form;
        $template->block_id = $this->block_id;
        $template->element_id = $this->element_id;
        $template->name = $name;
        $template->value = $value;
        if ($value) {
            $template->value_display = $this->mapValue($value);
        }
        $template->readonly = $readonly;
        $template->search = new SQLSearch(
            $this->form['form_settings']['blocks'][$this->block_id]['elements'][$this->element_id]['sql'],
            $this->form['form_settings']['blocks'][$this->block_id]['elements'][$this->element_id]['placeholder'],
            "Institut_id"
        );
        return $template;
    }

    public function mapValue($value)
    {
        //Should display the name and not the id
        if ($this->form['form_settings']['blocks'][$this->block_id]['elements'][$this->element_id]['mapper']) {
            $statement = DBManager::get()->prepare($this->form['form_settings']['blocks'][$this->block_id]['elements'][$this->element_id]['mapper']);
            $statement->execute(array('input' => $value));
            $result = $statement->fetch(PDO::FETCH_COLUMN, 0);
            return $result ?: "";
        } else {
            return $value;
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