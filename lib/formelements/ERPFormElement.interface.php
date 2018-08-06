<?php

interface ERPFormElement
{
    static function forDataType();

    static public function getName();

    static function forFieldNames();

    public function __construct(ERPForm $form);

    public function getSettingsTemplate($block_id, $element_id);

    public function getPreviewTemplate($block_id, $element_id);

    public function getElement($block_id, $element_id, $name, $value, $readonly);

    public function mapValue($value);
}