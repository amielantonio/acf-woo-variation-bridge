<?php

namespace ACFBridge\Base\Access;

use ACFBridge\Base\Access\ACF_Schema;

class ACF_Factory
{
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
     * contains the field group of the ACF instance
     *
     * @var string;
     */
    private $field_group_id;


    /**
     * Contains the collection of widgets under the field group
     *
     * @var array
     */
    private $widgets = [];

    public function __construct( $field_group_id)
    {
        $this->field_group = $field_group_id;
        $this->schema =  new ACF_Schema;
    }

    public function makeWidgets( $field_group_id)
    {
        $fieldGroupObj = (object) $this->getFieldGroupSchema( $field_group_id);

        if( ! is_object($field_group_id)) return "Invalid! ";

        foreach($fieldGroupObj as $fieldProperties ) {
            foreach($fieldProperties->fields as $field) {
                $this->make($field);
            }
        }

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

    /**
     * Render Widgets
     *
     * @param string $field_group
     * @return string
     */
    public function renderWidgets( $field_group = "" )
    {
        $field_group = $field_group <> "" ? $field_group : $this->field_group;

        return $this->makeWidgets( $field_group );
    }



    public function is_allowed($widget_type)
    {
        return in_array($widget_type, $this->allowedFields);
    }

    public function make( $field_group_object )
    {

    }

    public function getFieldGroupSchema( $field_group_id )
    {
        return $this->schema->getField($field_group_id);
    }



}
