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

    private $schema;

    public function __construct()
    {
        $this->schema =  new ACF_Schema;
    }

    public function makeWidgets( $field_group )
    {
        $fieldGroupObj = (object) $this->getFieldGroupSchema( $field_group );

        if( ! is_object($field_group)) return "Invalid! ";

        foreach($fieldGroupObj as $fieldProperties ) {
            foreach($fieldProperties->fields as $field) {
                $this->make($field);
            }
        }



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
