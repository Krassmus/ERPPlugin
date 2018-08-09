<?php

interface ERPFormElement
{
    static function forDataType();

    static public function getName();

    static function forFieldNames();

    public function __construct(ERPForm $form, $block_id, $element_id);

    public function getSettingsTemplate();

    public function getPreviewTemplate();

    public function getElement($name, $value, $readonly);

    public function mapValue($value);

    public function mapBeforeStoring($value);

    public function hookAfterStoring($newvalue, $oldvalue, $item);
}