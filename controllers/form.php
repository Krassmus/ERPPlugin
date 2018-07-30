<?php

class FormController extends PluginController
{
    function before_filter(&$action, &$args)
    {
        parent::before_filter($action, $args);
        $form_id = $args[0];
        $this->form = new ERPForm($form_id);
        Navigation::activateItem($this->form['navigation'] !== "/start" ? $this->form['navigation']."/".$form_id : "/".$form_id);
    }

    public function overview_action($form_id)
    {
    }

    public function edit_action($form_id, $item_id = null)
    {
        $class = $this->form['sorm_class'];
        $this->item = new $class($item_id);
        if (Request::isPost()) {
            $this->item->setData(Request::getArray("data"));
            $this->item->store();
            PageLayout::postSuccess(_("Daten wurden gespeichert."));
            $this->redirect("form/overview/".$form_id);
            return;
        }
    }

}