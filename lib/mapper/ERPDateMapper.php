<?php

class ERPDateMapper
{

    static public function forFieldNames()
    {
        return array("date", "beginn", "begin", "end", "ende");
    }

    public function map($value)
    {
        return date("c", $value);
    }
}