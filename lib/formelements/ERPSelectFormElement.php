<?php

class ERPSelectFormElement implements ERPFormElement
{

    protected $form = null;

    static public function getName()
    {
        return _("Selectbox");
    }

    static function forDataType()
    {
        return array("varchar", "text", "int", "integer");
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
        $tf = new Flexi_TemplateFactory(__DIR__."/../../views");
        $template = $tf->open("elements/settings/select.php");
        $template->form = $this->form;
        $template->block_id = $block_id;
        $template->element_id = $element_id;
        return $template;
    }

    public function getPreviewTemplate($block_id, $element_id)
    {
        $tf = new Flexi_TemplateFactory(__DIR__."/../../views");
        $template = $tf->open("elements/preview/select.php");
        $template->form = $this->form;
        $template->block_id = $block_id;
        $template->element_id = $element_id;
        if (trim($this->form['form_settings']['blocks'][$block_id]['elements'][$element_id]['sql'])) {
            if (stripos($this->form['form_settings']['blocks'][$block_id]['elements'][$element_id]['sql'], "SELECT ") === 0) {
                try {
                    $template->options = DBManager::get()
                        ->query($this->form['form_settings']['blocks'][$block_id]['elements'][$element_id]['sql'])
                        ->fetchAll();
                } catch (Exception $e) {
                    $template->options = array();
                }
            } else {
                $options = $this->form['form_settings']['blocks'][$block_id]['elements'][$element_id]['sql'];
                $options = explode("\n", $options);
                $options = array_map(function ($option) {
                    return explode("=", $option, 2);
                }, $options);
                $template->options = $options;
            }
        } else {
            $template->options = array();
        }
        return $template;
    }

    public function getElement($block_id, $element_id, $name, $value, $readonly)
    {
        $tf = new Flexi_TemplateFactory(__DIR__."/../../views");
        $template = $tf->open("elements/formelement/select.php");
        $template->form = $this->form;
        $template->block_id = $block_id;
        $template->element_id = $element_id;
        if (trim($this->form['form_settings']['blocks'][$block_id]['elements'][$element_id]['sql'])) {
            if (stripos($this->form['form_settings']['blocks'][$block_id]['elements'][$element_id]['sql'], "SELECT ") === 0) {
                try {
                    $template->options = DBManager::get()
                        ->query($this->form['form_settings']['blocks'][$block_id]['elements'][$element_id]['sql'])
                        ->fetchAll();
                } catch (Exception $e) {
                    $template->options = array();
                }
            } else {
                $options = $this->form['form_settings']['blocks'][$block_id]['elements'][$element_id]['sql'];
                $options = explode("\n", $options);
                $options = array_map(function ($option) {
                    return explode("=", $option, 2);
                }, $options);
                $template->options = $options;
            }
        } else {
            $template->options = array();
        }
        $template->name = $name;
        $template->value = $value;
        $template->readonly = $readonly;
        return $template;
    }

    public function mapValue($value)
    {
        return $value;
    }
}