<?php

namespace ACFBridge\Base\Access;

use ACFBridge\Base\Access\ACF_Schema;
use ACFBridge\Base\Access\ACF_Factory;

class ACF_Access {


    /**
     * contains the field group of the ACF instance
     *
     * @var string;
     */
    private $field_group;


    /**
     * Contains the collection of widgets under the field group
     *
     * @var array
     */
    private $widgets = [];


    public function __construct( $field_group )
    {
        $this->field_group = $field_group;
    }


    /**
     * Sets the field group of the ACF instances
     *
     * @param string $field_group
     */
    public function setFieldGroup($field_group)
    {
        $this->field_group = $field_group;
    }

    /**
     * @return string
     */
    public function getFieldGroup()
    {
        return $this->field_group;
    }


    public function createWidget( $widget_type )
    {

    }


}
