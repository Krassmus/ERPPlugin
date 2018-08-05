<?php

class PseudoSorm
{
    static public function create($table_or_sormclass, $item_id = null)
    {
        if (is_subclass_of($table_or_sormclass, "SimpleORMap")) {
            $object = new $table_or_sormclass($item_id);
            return $object;
        } else {
            $GLOBALS['PSEUDOSORM_TABLE_NAME'] = $table_or_sormclass;

            $object = new class($item_id) extends SimpleORMap {
                protected static function configure($config = array())
                {
                    $config['db_table'] = $GLOBALS['PSEUDOSORM_TABLE_NAME'];
                    parent::configure($config);
                    return $config;
                }
            };
            return $object;
        }

    }
}