<?php

class ERPForm extends SimpleORMap
{

    static public function findMine($user_id = null)
    {
        $user_id || $user_id = $GLOBALS['user']->id;
        if ($GLOBALS['perm']->have_perm("root", $user_id)) {
            return self::findAll();
        }
        $roles = RolePersistence::getAssignedRoles($user_id, true);
        $role_ids = array_keys($roles);
        $statement = DBManager::get()->prepare("
            SELECT erp_forms.*
            FROM erp_forms
                INNER JOIN erp_form_roles ON (erp_form_roles.form_id = erp_forms.form_id)
            WHERE erp_form_roles.role_id IN (?)
            ORDER BY erp_forms.name ASC
        ");
        $statement->execute(array($role_ids));
        $forms = array();
        foreach ($statement->fetchAll(PDO::FETCH_ASSOC) as $form_data) {
            $forms[] = ERPForm::buildExisting($form_data);
        }
        return $forms;
    }

    static public function findAll()
    {
        return self::findBySQL("1 ORDER BY name ASC");
    }

    protected static function configure($config = array())
    {
        $config['db_table'] = 'erp_forms';
        $config['serialized_fields']['overview_settings'] = "JSONArrayObject";
        $config['serialized_fields']['form_settings'] = "JSONArrayObject";
        parent::configure($config);
    }

    public function getRoles()
    {
        $statement = DBManager::get()->prepare("
            SELECT role_id
            FROM erp_form_roles
            WHERE form_id = ?
        ");
        $statement->execute(array($this->getId()));
        return $statement->fetchAll(PDO::FETCH_COLUMN, 0);
    }

    public function getTableFields()
    {
        $sorm_class = $this['sorm_class'];
        $object = new $sorm_class();
        $sorm_metadata = $object->getTableMetadata();
        $fields = $sorm_metadata['fields'];
        if ($sorm_class === "User") {
            $userinfometadata = $object->info->getTableMetadata();
            $fields = array_merge($fields, $userinfometadata['fields']);
        }
        return array_keys($fields);
    }
}