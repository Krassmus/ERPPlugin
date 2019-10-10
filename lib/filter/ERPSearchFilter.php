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
        /*$tf = new Flexi_TemplateFactory(__DIR__."/../../views");
        $template = $tf->open("filters/settings/search.php");
        $template->form = $this->form;
        $template->block_id = $this->filter_id;
        return $template;*/
    }

    public function addFilter(\ERP\SQLQuery $query)
    {
        $name = "erpfilter_".$this->form->getId()."_".$this->filter_id."_search";
        if (UserConfig::get(User::findCurrent()->id)->$name) {
            $sorm_class = $this->form['sorm_class'];
            $dummy_object = new $sorm_class();
            $sorm_metadata = $dummy_object->getTableMetadata();

            $conditions = array();


            foreach ($sorm_metadata['fields'] as $field) {
                if (mb_strpos($field['type'], 'text') !== false || mb_strpos($field['type'], 'char') !== false) {
                    $conditions[] = $field['name'] . " LIKE :" . $name;
                }
            }

            $query->where(
                $this->filter_id,
                " ( ".implode(" OR ", $conditions)." ) ",
                array($name => "%" . UserConfig::get(User::findCurrent()->id)->$name . "%")
            );
        }
    }

    public function addToSidebar()
    {
        $name = "erpfilter_".$this->form->getId()."_".$this->filter_id."_search";
        $search_widget = new SearchWidget(URLHelper::getURL("plugins.php/erpplugin/form/set_user_config/".$this->form->getId(), array(
            'name' => $name
        )));
        $search_widget->setMethod("post");
        $search_widget->addNeedle(
            _("Suchen"),
            $name,
            _("Suche nach ..."),
            null,
            null,
            UserConfig::get(User::findCurrent()->id)->$name
        );
        Sidebar::Get()->addWidget($search_widget);
    }

}