<?php

class ERPSearchFilter implements ERPFilter
{

    protected $form = null;
    protected $filter_id = null;

    static public function getName()
    {
        return _("Freitextsuche");
    }

    public function __construct(ERPForm $form, $filter_id)
    {
        $this->form = $form;
        $this->filter_id = $filter_id;
    }

    public function getSettingsTemplate()
    {
        $tf = new Flexi_TemplateFactory(__DIR__."/../../views");
        $template = $tf->open("filters/settings/search.php");
        $template->form = $this->form;
        $template->block_id = $this->filter_id;
        return $template;
    }

    public function addFilter(\ERP\SQLQuery $query)
    {

    }

}