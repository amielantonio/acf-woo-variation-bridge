<?php

namespace ACFBridge\Base\Access;

use ACFBridge\Fields\ACF_Builder;
use ACFBridge\IntegrationMethods;
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
     * Post ID
     *
     * @var int
     */
    private $postID;

    /**
     * check if the field should contain a loop or array support
     *
     * @var bool
     */
    private $loop_support = false;

    /**
     * Counter for the loop
     *
     * @var int
     */
    private $ctr;

    /**
     * ID of the parent HTML
     *
     * @var string
     */
    private $html_id;

    /**
     * Class of the parent HTML
     *
     * @var array
     */
    private $html_class = [];

    private $dataAttributes = [];

    private $attributes = [];

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
     * @param IntegrationMethods $integration
     */
    public function __construct(IntegrationMethods $integration)
    {
        /*
         * add the properties of the integration to factory
         */
        foreach($integration as $key => $value)
        {
            $this->$key = $value;
        }

        $this->schema = new ACF_Schema;
    }

    /**
     * Make widgets under that are under the field group
     *
     * @param $field_group_id
     * @return bool | string
     * @throws Exception
     */
    public function makeWidgets($field_group_id)
    {
        $fieldGroupObj = (object)$this->getFieldGroupSchema($field_group_id);

        $html = "";

        if (!is_object($fieldGroupObj)) return false;

        foreach ($fieldGroupObj as $fieldProperties) {
            foreach ($fieldProperties['fields'] as $field) {
                $html .= $this->makeWidget($field);
            }
        }

        return $html;
    }

    /**
     * Render the HTML widget
     *
     * @param string $field_group_id
     * @return bool
     * @throws Exception
     */
    public function renderWidgets($field_group_id = "")
    {
        $field_group_id = $field_group_id <> "" ? $field_group_id : $this->field_group_id;

        return $this->makeParent($this->makeWidgets($field_group_id), true);
    }

    /**
     * Render a single widget
     *
     * @param string $field_id
     * @return bool | string
     * @throws Exception
     */
    public function renderWidget($field_id = "")
    {
        $field_id = $field_id <> "" ? $field_id : $this->field_id;

        $fieldObj = (object)$this->getFieldSchema($field_id);

        var_dump($fieldObj);

        return $this->makeParent($this->makeWidget($fieldObj), true);
    }

    /**
     * Check to see if the widget should have a parent or not,
     * depending on the place where it was called;
     *
     * @param $child
     * @param bool $makeParent
     * @return string
     */
    public function makeParent($child, $makeParent = false)
    {
        if ($makeParent) {
            $id = $this->html_id;
            $class = implode(" ", $this->html_class);
            $dataAttributes = $this->createDataAttributesHTML();

            return "<div class='bridge-parent $class' id='{$id}' {$dataAttributes}>

                        {$child}
                    </div>";
        }

        return $child;

    }




    /**
     * Create the html format of the data attribute
     *
     * @return string
     */
    private function createDataAttributesHTML()
    {
        $html = "";

        /*
         * Make sure that we wont be returning any
         * random html code when data attribute is empty
         */
        if(!empty($this->dataAttributes)){
            foreach($this->dataAttributes as $key => $attribute) {
                $html .= "data-{$key}='{$attribute}'";
            }

            return $html;
        }

        return "";
    }

    /**
     * Call the build process
     *
     * @param $field
     * @return bool | string
     * @throws Exception
     */
    public function makeWidget($field)
    {
        try {

            $options['options'] = [
                "loop_support" => $this->loop_support,
                "ctr" => $this->ctr,
                "post_id" => $this->postID
            ];

            $builder = new ACF_Builder($field, $options);
            return $builder->build();
        } catch (Exception $e) {
            echo $e;
        }
    }

    /**
     *
     *
     * @param $field_group_id
     * @return object|string
     */
    public function getFieldGroupSchema($field_group_id)
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
    public function getFieldSchema($field_id)
    {
        return $this->widgets = $this->schema->getField($field_id);
    }


    /**
     * Set the id of the field
     *
     * @param $field_id
     */
    public function setFieldID($field_id)
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
