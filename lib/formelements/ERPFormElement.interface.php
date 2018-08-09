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

    /**
     * Changes the $value from the request to the $value that should be inserted in the database.
     * For instance you could map a date string like 12.03.2018 to a Unix-Timestamp.
     * @param string $value : something from the request
     * @return string : another value
     *
     */
    public function mapBeforeStoring($value);

    public function hookAfterStoring($newvalue, $oldvalue, $item);
}