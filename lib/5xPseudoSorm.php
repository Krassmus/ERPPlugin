<?php

class PseudoSorm
{
    static public function create($table_or_sormclass, $item_id = null)
    {
        if (is_subclass_of($table_or_sormclass, "SimpleORMap")) {
            $object = new $table_or_sormclass($item_id);
            return $object;
        }
    }
}