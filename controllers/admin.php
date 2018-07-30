<?php

class AdminController extends PluginController
{
    function before_filter(&$action, &$args)
    {
        parent::before_filter($action, $args);
        if (!$GLOBALS['perm']->have_perm("root")) {
            throw new AccessDeniedException();
        }
        Navigation::activateItem("/admin/config/forms");
        PageLayout::setTitle(_("Formularbaukasten"));
    }

    public function overview_action()
    {
        $this->forms = ERPForm::findAll();
    }

    public function edit_action($form_id = null)
    {
        PageLayout::setTitle($form_id ? _("Formular bearbeiten") : _("Formular erstellen"));
        $this->form = new ERPForm($form_id);
        if (Request::isPost()) {
            $this->form->setData(Request::getArray("data"));
            $this->form->store();

            $statement = DBManager::get()->prepare("
                DELETE FROM erp_form_roles 
                WHERE form_id = :form_id
                    AND role_id NOT IN (:role_ids)
            ");
            $statement->execute(array(
                'form_id' => $this->form->getId(),
                'role_ids' => Request::getArray("roles")
            ));
            $statement = DBManager::get()->prepare("
                    INSERT IGNORE INTO erp_form_roles
                    SET role_id = :role_id,
                    form_id = :form_id
                ");
            foreach (Request::getArray("roles") as $role_id) {
                $statement->execute(array(
                    'form_id' => $this->form->getId(),
                    'role_id' => $role_id
                ));
            }

            PageLayout::postSuccess(_("Daten wurden gespeichert"));
            $this->redirect("admin/overview");
        }
        $this->icons = array();
        foreach (scandir($GLOBALS['STUDIP_BASE_PATH']."/public/assets/images/icons/blue") as $file) {
            if ($file[0] !== "." && !is_dir($GLOBALS['STUDIP_BASE_PATH']."/public/assets/images/icons/blue/".$file)) {
                $this->icons[] = $file;
            }
        }
    }

    public function delete_action($form_id)
    {
        $this->form = new ERPForm($form_id);
        if (Request::isPost()) {
            $this->form->delete();
            PageLayout::postSuccess(_("Formular wurde gelöscht."));
            $this->redirect("admin/overview");
        }
    }

    public function editoverview_action($form_id)
    {
        PageLayout::setTitle(_("Übersicht bearbeiten"));
        $this->form = new ERPForm($form_id);
        if (Request::isPost()) {
            $this->form->setData(Request::getArray("data"));
            $this->form->store();
            PageLayout::postSuccess(_("Daten wurden gespeichert"));
            $this->redirect("admin/overview");
        }

        $sorm_class = $this->form['sorm_class'];
        $object = new $sorm_class();
        $sorm_metadata = $object->getTableMetadata();
        $fields = $sorm_metadata['fields'];
        if ($sorm_class === "User") {
            $userinfometadata = $object->info->getTableMetadata();
            $fields = array_merge($fields, $userinfometadata['fields']);
        }
        $this->fieldnames = array_keys($fields);
    }

    public function editform_action($form_id)
    {
        PageLayout::setTitle(_("Formular bearbeiten"));
        $this->form = new ERPForm($form_id);
        if (Request::isPost()) {
            $this->form['form_settings'] = Request::getArray("form_settings");
            $this->form->store();
            PageLayout::postSuccess(_("Daten wurden gespeichert"));
            $this->redirect("admin/overview");
        }
    }



}