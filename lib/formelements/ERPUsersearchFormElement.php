<?php

class ERPUsersearchFormElement implements ERPFormElement
{

    protected $form = null;
    protected $block_id = null;
    protected $element_id = null;

    static public function getName()
    {
        return _("Personensuche");
    }

    static function forDataType()
    {
        return array("varchar");
    }

    static function forFieldNames()
    {
        return array("user_id", "autor_id", "dozent_id");
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
        $template = $tf->open("elements/settings/usersearch.php");
        $template->form = $this->form;
        $template->block_id = $this->block_id;
        $template->element_id = $this->element_id;
        return $template;
    }

    public function getPreviewTemplate()
    {
        $tf = new Flexi_TemplateFactory(__DIR__."/../../views");
        $template = $tf->open("elements/preview/usersearch.php");
        $template->form = $this->form;
        $template->block_id = $this->block_id;
        $template->element_id = $this->element_id;
        return $template;
    }

    public function getElement($name, $value, $readonly)
    {
        $tf = new Flexi_TemplateFactory(__DIR__."/../../views");
        $template = $tf->open("elements/formelement/usersearch.php");
        $template->form = $this->form;
        $template->block_id = $this->block_id;
        $template->element_id = $this->element_id;
        $template->name = $name;
        $template->value = $value;
        if ($value) {
            $template->value_display = $this->mapValue($value);
        }
        $template->readonly = $readonly;
        $template->search = new StandardSearch("user_id");
        return $template;
    }

    public function mapValue($value)
    {
        $user = User::find($value);
        if ($user) {
            return $user->getFullName();
        }
    }

    public function mapBeforeStoring($value)
    {
        return $value;
    }

    public function hookAfterStoring($newvalue, $oldvalue, $item)
    {
        var_dump($newvalue);
        var_dump($oldvalue);
        var_dump($this->form['form_settings']['blocks'][$this->block_id]['elements'][$this->element_id]['notify']);
        if (($newvalue !== $oldvalue)
                && $newvalue
                && ($newvalue !== $GLOBALS['user']->id)
                && ($this->form['form_settings']['blocks'][$this->block_id]['elements'][$this->element_id]['notify'])) {
            //Notification an Nutzer senden
            PersonalNotifications::add(
                $newvalue,
                "",
                _("Sie sind eingetragen worden.")
            );
        }
    }
}