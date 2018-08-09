<?php

interface ERPFilter
{

    static public function getName();

    public function __construct(ERPForm $form, $filter_id);

    public function getSettingsTemplate();

    public function addFilter(\ERP\SQLQuery $query);

}