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
    public $field_group_id;

    /**
     * Field OD
     *
     * @var int | null
     */
    public $field_id;


    /**
     * Post id where to get the post meta
     *
     * @var int
     */
    public $postID;

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
    public $ctr = 0;

    /**
     * Contains the html id
     *
     * @var string
     */
    public $html_id;

    /**
     * Contains the html class
     *
     * @var array
     */
    public $html_class = [];

    /**
     * Add Data attributes to parent HTML
     *
     * @var array
     */
    public $dataAttributes = [];

    /**
     * Allowed Fields
     *
     * @var array
     */
    private $supportedFields = [
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
     * Parent element formatting CSS
     *
     * @var
     */
    private $format;

    /**
     * Specifies the number of items inside the row;
     *
     * @var
     */
    private $fit;

    /**
     * Inline CSS style
     *
     * @var string;
     */
    private $style;

    public function __construct()
    {
        add_action('admin_enqueue_scripts', array(__CLASS__, 'scripts'));
    }

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

    public function scripts()
    {

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

        self::$instance->field_group_id = $field_group_id;

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
     * @param int $ctr
     * @return IntegrationMethods
     */
    public function addLoopingSupport( $ctr = 0 )
    {
        $this->loop_support = true;

        $this->ctr = $ctr;

        return $this->instance();
    }

    /**
     * Add post to the integration
     *
     * @param $post_id
     * @return IntegrationMethods
     */
    public function post( $post_id )
    {
        $this->postID = $post_id;

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

    /**
     * Set all html class instead of adding new classes
     *
     * @param $class
     * @return IntegrationMethods
     */
    public function setParentHtmlClass( $class )
    {
        $this->html_class = $class;

        return $this->instance();
    }

    /**
     * Formats the parent element of the form group
     *
     * @param $format
     * @param $fit - from 0 - 4
     * @return $this
     */
    public function format( $format, $fit = 0 )
    {
        $acceptedFormats = [
            'row'           => 'bridge-row',
            'column'        => 'bridge-column',
            'row wrap'      => 'bridge-row-wrap',
            'column wrap'   => 'bridge-column-wrap',
        ];

        if($fit < 0 || $fit > 4){
            $fit = 0;
        }

        /*
         * Checks whether the specified format of the user is
         * available within the key settings of our integration
         *
         * if the format is accepted, register the corresponding
         * css class.
         */
        if(in_array($format, array_keys($acceptedFormats))){
            $this->format = $format;
            $this->fit = $fit;
            $this->html_class[] = $acceptedFormats[$format];
            $this->html_class[] = "fit-{$fit}";
        }

        /*
         * If the submitted format is an array, we can conclude
         * that the submitted format is a css configuration, so
         * we will register it under the style config.
         */
        if(is_array($format)){
            foreach($format as $key => $value) {
                $this->style .= "{$key}: {$value};";
            }
        }



        return $this;
    }

    /**
     * Add data attribute support
     *
     * @param $key
     * @param string $value
     * @return IntegrationMethods
     */
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
        if($this->field_group_id) {
            $factory = new ACF_Factory($this);

            echo $factory->renderWidgets();
        } else {
            $factory = new ACF_Factory($this);

            echo $factory->renderWidget($this->field_id);
        }
    }

}
