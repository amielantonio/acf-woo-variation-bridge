<?php

namespace ACFBridge;

use ACFBridge\Base\Access\ACF_Factory;
use Exception;

class IntegrationMethods
{

    /**
     * Singleton Instance
     *
     * @var IntegrationMethods
     */
    public static $instance;

    /**
     * Field Group ID
     *
     * @var int | null
     */
    public $field_group;

    /**
     * Field OD
     *
     * @var int | null
     */
    public $field_id;

    /**
     * Loop support for the widgets
     *
     * @var bool
     */
    public $loop_support = false;

    /**
     * Loop support counter
     *
     * @var int
     */
    private $ctr = 0;

    /**
     * Contains the html id
     *
     * @var string
     */
    private $html_id;

    /**
     * Contains the html class
     *
     * @var array
     */
    private $html_class = [];

    /**
     * Add Data attributes to parent HTML
     *
     * @var array
     */
    private $dataAttributes = [];


    /**
     * Initialize Class
     */
    public static function init()
    {
        //Check for Instance
        if (self::$instance === null) {
            self::$instance = new self;
        }

        self::$instance->autoload();

    }

    /**
     * Autoload vendor
     */
    private function autoload()
    {
        require_once __DIR__ . '/../vendor/autoload.php';
    }

    /**
     * Set the field group from ACF based on the ID given
     *
     * @param $field_group_id
     * @return IntegrationMethods
     * @throws Exception
     */
    public static function setFieldGroup($field_group_id)
    {
        self::init();

        self::$instance->field_group = $field_group_id;

        return self::$instance->instance();
    }

    /**
     * return the instance of this class
     *
     * @return $this
     */
    protected function instance()
    {
        return $this;
    }

    /**
     * Set the field based on the ID given
     *
     * @param $field_id
     * @return IntegrationMethods
     * @throws Exception
     */
    public static function setFieldId($field_id)
    {
        self::init();

        self::$instance->field_id = $field_id;

        return self::$instance;
    }

    /**
     * Add support for this fields that are called inside a loop
     *
     * @param $ctr
     * @return IntegrationMethods
     */
    public function addLoopingSupport( $ctr )
    {
        $this->loop_support = true;

        $this->ctr = $ctr;

        return $this->instance();
    }

    /**
     * Sets the parent html ID
     *
     * @param $id
     * @return $this
     */
    public function setParentHtmlID( $id )
    {
        $this->html_id = $id;

        return $this->instance();
    }

    /**
     * Add a class for the parent
     *
     * @param $class
     * @return $this
     */
    public function addParentHtmlClass( $class )
    {
        if(is_array($class)){
            $this->html_class = array_merge($this->html_class, $class);
        } else {
            $this->html_class[] = $class;
        }

        return $this->instance();
    }

    public function setParentHtmlClass( $class )
    {
        $this->html_class = $class;

        return $this->instance();
    }

    public function addDataAttribute($key, $value = "")
    {
        if(is_array($key)){
            $this->dataAttributes = array_merge($this->dataAttributes, $key);
        } else {
            $this->dataAttributes[$key] = $value;
        }

        return $this->instance();
    }


    /**
     * Render the Widget created from the factory
     *
     * @throws Exception
     */
    public function render()
    {
        if($this->field_group) {
            $factory = new ACF_Factory($this->field_group, $this->loop_support, $this->ctr);

            echo $factory->addParentHtmlClass($this->html_class)
                ->setParentHtmlID($this->html_id)
                ->addDataAttributes($this->dataAttributes)
                ->renderWidgets();
        } else {
            $factory = new ACF_Factory(null, $this->loop_support, $this->ctr);

            echo $factory->addParentHtmlClass($this->html_class)
                ->setParentHtmlID($this->html_id)
                ->addDataAttributes($this->dataAttributes)
                ->renderWidget($this->field_id);
        }
    }

}
