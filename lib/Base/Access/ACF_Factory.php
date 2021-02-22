<?php

namespace ACFBridge\Base\Access;

use ACFBridge\Fields\ACF_Builder;

class ACF_Factory
{

    /**
     * contains the field group of the ACF instance
     *
     * @var int;
     */
    private $field_group_id;


    /**
     * contains the field id
     *
     * @var int;
     */
    private $field_id;


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
     * ACF Schema
     *
     * @var ACF_Schema
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

        if( ! is_object($fieldGroupObj)) return false;

        foreach($fieldGroupObj as $fieldProperties ) {
            foreach($fieldProperties['fields'] as $field) {
                $this->makeWidget($field);
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

    public function renderWidget( $field_id = "" )
    {
        $field_id = $field_id <> "" ? $field_id : $this->field_id;

        $fieldObj = (object) $this->getFieldSchema($field_id);

        return $this->makeWidget($fieldObj);
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
     * @param $field
     * @return string
     */
    public function makeWidget( $field )
    {

        $builder = new ACF_Builder;

        $builder->build($field);

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



    public function getFieldSchema( $field_id )
    {
        return $this->widgets = $this->schema->getField($field_id);
    }


    public function setFieldID( $field_id )
    {
        $this->field_id = $field_id;
    }

    public function getFieldID()
    {
        return $this->field_id;
    }

}
