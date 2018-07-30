<?php

interface ERPFormElement
{
    static function forDataType();

    static function forFieldNames();

    public function __construct(ERPForm $form);

    public function getSettingsTemplate();

    public function getPreviewTemplate();

    public function getElement($name, $value);
}