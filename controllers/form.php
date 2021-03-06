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
        $object = PseudoSorm::create($this->form['sorm_class']);
        $sorm_metadata = $object->getTableMetadata();

        $query = \ERP\SQLQuery::table($sorm_metadata['table']);
        $overview_settings = $this->form['overview_settings']->getArrayCopy();
        foreach ((array) $overview_settings['filters'] as $filter_id => $filter) {
            $filter_class = $filter['type'];
            $filter_object = new $filter_class($this->form, $filter_id);
            $filter_object->addToSidebar();
            $filter_object->addFilter($query);

            /*if (Request::get("filter_".$filter_id)) {
                foreach ((array) $filter['joins'] as $join) {
                    $query->join(
                        $join['alias'],
                        $join['table'],
                        $join['on'],
                        $join['inner'] ? "INNER JOIN" : "LEFT JOIN"
                    );
                }
                $query->where(
                    md5($filter['where']),
                    str_replace(":input", ":".'filter_'.$filter_id, $filter['where']),
                    array('filter_'.$filter_id => Request::get("filter_".$filter_id))
                );
            }*/
        }
        if ($overview_settings['sort']) {
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
        $this->item = PseudoSorm::create($this->form['sorm_class'], $item_id);
        if (Request::isPost()) {
            $data = Request::getArray("data");
            //check for permissions
            $form_settings = (array) ($this->form['form_settings'] ? $this->form['form_settings']->getArrayCopy() : array());
            if (!$GLOBALS['perm']->have_perm("root")) {
                $roles = RolePersistence::getAssignedRoles($GLOBALS['user']->id, true);
                $role_ids = array_keys($roles);
                $allowed_fields = array();
                foreach ((array) $form_settings['blocks'] as $block_id => $block) {
                    if (in_array("all", (array) $block['visibility'])
                            || count(array_intersect((array) $block['visibility'], $role_ids)) > 0) {
                        foreach ((array) $block['elements'] as $element) {
                            if ($element['field']
                                && (in_array("all", (array)$element['edit_permissions'])
                                    || count(array_intersect($role_ids, (array)$element['edit_permissions'])))) {
                                $allowed_fields[] = $element['field'];
                            }
                        }
                    }
                }
                $allowed_data = array();
                foreach ($data as $i => $value) {
                    if (in_array($i, $allowed_fields)) {
                        //eventually map value

                        $allowed_data[$i] = $value;
                    }
                }
            } else {
                $allowed_data = $data;
            }

            foreach ($allowed_data as $i => $value) {
                foreach ((array) $form_settings['blocks'] as $block_id => $block) {
                    foreach ((array) $block['elements'] as $element_id => $element) {
                        if ($element['field'] === $i) {
                            $class = $element['type'];
                            $form_element = new $class($this->form, $block_id, $element_id);
                            $allowed_data[$i] = $form_element->mapBeforeStoring($value);
                            break 2;
                        }
                    }
                }
            }

            $olddata = $this->item->toRawArray();
            $this->item->setData($allowed_data);
            $this->item->store();

            //Post-storing hook:
            foreach ($allowed_data as $i => $value) {
                foreach ((array) $form_settings['blocks'] as $block_id => $block) {
                    foreach ((array) $block['elements'] as $element_id => $element) {
                        if ($element['field'] === $i) {
                            $class = $element['type'];
                            $form_element = new $class($this->form, $block_id, $element_id);
                            $form_element->hookAfterStoring($value, $olddata[$i], $this->item);
                        }
                    }
                }
            }

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

    public function set_user_config_action($form_id)
    {
        if (Request::get("name") && strpos(Request::get("name"), "erpfilter_") === 0) {
            if (Request::get("reset-search")) {
                $GLOBALS['user']->cfg->store(Request::get("name"), null);
            } elseif (Request::isPost()) {
                $GLOBALS['user']->cfg->store(Request::get("name"), Request::get(Request::get("name")));
            }
        }
        $this->redirect("form/overview/".$form_id);
    }

}