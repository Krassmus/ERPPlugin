<?php

class FormController extends PluginController
{
    function before_filter(&$action, &$args)
    {
        parent::before_filter($action, $args);
        $form_id = $args[0];
        $this->form = new ERPForm($form_id);
        PageLayout::setTitle($this->form['name']);
        Navigation::activateItem($this->form['navigation'] !== "/start" ? $this->form['navigation']."/".$form_id : "/".$form_id);
    }

    public function overview_action($form_id)
    {
        //$class = $this->form['sorm_class'];
        //$object = new $class();
        $object = PseudoSorm::create($this->form['sorm_class']);
        $sorm_metadata = $object->getTableMetadata();

        $query = \ERP\SQLQuery::table($sorm_metadata['table']);
        if ($this->form['overview_settings']['sort']) {
            $query->orderBy($this->form['overview_settings']['sort']. " ".($this->form['overview_settings']['sort_desc'] ? "DESC" : "ASC"));
        }
        if ($query->count() <= 500) {
            $this->items = $query->fetchAll($this->form['sorm_class']); //TODO create anomymous class
        } else {
            PageLayout::postInfo(_("Geben Sie mehr Filter ein."));
        }
    }

    public function edit_action($form_id, $item_id = null)
    {
        PageLayout::setTitle(_("Objekt bearbeiten"));
        //$class = $this->form['sorm_class'];
        //$this->item = new $class($item_id);
        $this->item = PseudoSorm::create($this->form['sorm_class'], $item_id);
        if (Request::isPost()) {
            $this->item->setData(Request::getArray("data"));
            $this->item->store();
            PageLayout::postSuccess(_("Daten wurden gespeichert."));
            $this->redirect("form/overview/".$form_id);
            return;
        }
    }

    public function delete_action($form_id, $item_id)
    {
        //$class = $this->form['sorm_class'];
        //$this->item = new $class($item_id);
        $this->item = PseudoSorm::create($this->form['sorm_class'], $item_id);
        if (Request::isPost()) {
            $this->item->delete();
            PageLayout::postSuccess(_("Objekt wurde gelöscht."));
            $this->redirect("form/overview/".$form_id);
            return;
        }
    }

}