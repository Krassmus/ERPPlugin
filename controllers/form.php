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
        $this->item = PseudoSorm::create($this->form['sorm_class'], $item_id);
        if (Request::isPost()) {
            $data = Request::getArray("data");
            //check for permissions
            $form_settings = (array) ($this->form['form_settings'] ? $this->form['form_settings']->getArrayCopy() : array());
            if (!$GLOBALS['perm']->have_perm("root")) {
                $roles = RolePersistence::getAssignedRoles($GLOBALS['user']->id, true);
                $role_ids = array_keys($roles);
                $allowed_fields = array();
                foreach ((array) $form_settings['blocks'] as $block) {
                    foreach ((array) $block['elements'] as $element) {
                        if ($element['field']
                                && (in_array("all", (array) $element['edit_permissions'])
                                    || count(array_intersect($role_ids, (array) $element['edit_permissions'])))) {
                            $allowed_fields[] = $element['field'];
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

}