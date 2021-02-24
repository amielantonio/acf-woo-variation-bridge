<?php

namespace ACFBridge\Base\Access;

use ACFBridge\Fields\ACF_Builder;
use Exception;

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
     * Make widgets under that are under the field group
     *
     * @param $field_group_id
     * @return bool
     * @throws Exception
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
     * Render the HTML widget
     *
     * @param string $field_group_id
     * @return bool
     * @throws Exception
     */
    public function renderWidgets( $field_group_id = "" )
    {
        $field_group_id = $field_group_id <> "" ? $field_group_id : $this->field_group_id;

        return $this->makeWidgets( $field_group_id );
    }

    /**
     * Render a single widget
     *
     * @param string $field_id
     * @return bool | string
     * @throws Exception
     */
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
     * Call the build process
     *
     * @param $field
     * @return bool | string
     * @throws Exception
     */
    public function makeWidget( $field )
    {
        try {
            $builder = new ACF_Builder;
            return $builder->build($field);
        } catch (Exception $e){
            echo $e;
        }
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


    /**
     * Get the field's schema
     *
     * @param $field_id
     * @return object|string
     */
    public function getFieldSchema( $field_id )
    {
        return $this->widgets = $this->schema->getField($field_id);
    }


    /**
     * Set the id of the field
     *
     * @param $field_id
     */
    public function setFieldID( $field_id )
    {
        $this->field_id = $field_id;
    }

    /**
     * Get the id of the field
     *
     * @return int
     */
    public function getFieldID()
    {
        return $this->field_id;
    }

}
