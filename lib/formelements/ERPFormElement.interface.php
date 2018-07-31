<?php

interface ERPFormElement
{
    static function forDataType();

    static function forFieldNames();

    public function __construct(ERPForm $form);

    public function getSettingsTemplate();

    public function getPreviewTemplate($block_id, $element_id);

    public function getElement($name, $value);
}