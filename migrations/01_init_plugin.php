<?php

class InitPlugin extends Migration
{
    
    public function up()
    {
        DBManager::get()->exec("
            CREATE TABLE IF NOT EXISTS `erp_forms` (
                `form_id` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
                `name` varchar(64) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                `icon` varchar(16) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                `navigation` varchar(128) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                `sorm_class` varchar(64) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                `overview_settings` text COLLATE utf8mb4_unicode_ci,
                `form_settings` text COLLATE utf8mb4_unicode_ci,
                `chdate` int(11) DEFAULT NULL,
                `mkdate` int(11) DEFAULT NULL,
                PRIMARY KEY (`form_id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
        ");

        DBManager::get()->exec("
            CREATE TABLE IF NOT EXISTS `erp_form_roles` (
                `form_id` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
                `role_id` int(10) unsigned NOT NULL,
                PRIMARY KEY (`form_id`, `role_id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
        ");

    }

    public function down()
    {
        DBManager::get()->exec("
            DROP TABLE IF EXISTS `erp_forms`;
        ");

        DBManager::get()->exec("
            DROP TABLE IF EXISTS `erp_form_roles`;
        ");
    }

}