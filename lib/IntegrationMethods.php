<?php

namespace ACFBridge;

use ACFBridge\Base\Access\ACF_Factory;

class IntegrationMethods
{

    /**
     * Singleton Instance
     *
     * @var IntegrationMethods
     */
    public static $instance;

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

    private function autoload()
    {
        require_once __DIR__ . '/../vendor/autoload.php';
    }

    protected function instance()
    {
        return $this;
    }

    public static function getFieldsFromGroup($field_group_id)
    {
        self::init();

        $factory = new ACF_Factory($field_group_id);

        $factory->renderWidgets();
    }

    public static function getFieldById($field_id)
    {
        self::init();

        $factory = new ACF_Factory($field_id);

        $factory->renderWidget($field_id);
    }

    public static function renderField( $field )
    {

    }

}
