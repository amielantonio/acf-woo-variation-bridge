<?php

namespace ACFBridge\Base\Access;

use ACFBridge\Base\Access\ACF_Schema;
use ACFBridge\Base\Access\ACFBuilder;

class ACF_Factory
{

    /**
     * contains the field group of the ACF instance
     *
     * @var string;
     */
    private $field_group_id;


    /**
     * Allowed Fields
     *
     * @var array
     */
    private $allowedFields = [
        'text',
        'textarea',
        'number',
        'email',
        'url',
        'password',
        'wysiwyg_editor',
        'select',
        'checkbox',
        'radio_button',
        'true_false',
        'link',
        'post_object',
    ];

    /**
     *
     *
     * @var \ACFBridge\Base\Access\ACF_Schema
     */
    private $schema;

    /**
     * Contains the collection of widgets under the field group
     *
     * @var array
     */
    private $widgets = [];

    /**
     * ACF_Factory constructor.
     *
     * @param $field_group_id
     */
    public function __construct( $field_group_id)
    {
        $this->field_group_id = $field_group_id;
        $this->schema =  new ACF_Schema;
    }

    /**
     *
     *
     * @param $field_group_id
     * @return string
     */
    public function makeWidgets( $field_group_id )
    {
        $fieldGroupObj = (object) $this->getFieldGroupSchema( $field_group_id);

        if( ! is_object($field_group_id)) return false;

        foreach($fieldGroupObj as $fieldProperties ) {
            foreach($fieldProperties->fields as $field) {
                $this->make($field);
            }
        }

        return true;
    }

    /**
     * Render Widgets
     *
     * @param string $field_group_id
     * @return string
     */
    public function renderWidgets( $field_group_id = "" )
    {
        $field_group_id = $field_group_id <> "" ? $field_group_id : $this->field_group_id;

        return $this->makeWidgets( $field_group_id );
    }

    /**
     *
     *
     * @param $widget_type
     * @return bool
     */
    public function is_allowed($widget_type)
    {
        return in_array($widget_type, $this->allowedFields);
    }

    /**
     *
     *
     * @param $field_group_object
     */
    public function make( $field_group_object )
    {

    }

    /**
     *
     *
     * @param $field_group_id
     * @return object|string
     */
    public function getFieldGroupSchema( $field_group_id )
    {
        return $this->widgets = $this->schema->getField($field_group_id);
    }

    /**
     * Sets the field group of the ACF instances
     *
     * @param string $field_group_id
     */
    public function setFieldGroup($field_group_id)
    {
        $this->field_group_id = $field_group_id;
    }

    /**
     * Get the current field group of the class
     *
     *
     * @return string
     */
    public function getFieldGroup()
    {
        return $this->field_group_id;
    }

}
