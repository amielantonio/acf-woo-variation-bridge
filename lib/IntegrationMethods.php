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
     * return the instance of this class
     *
     * @return $this
     */
    protected function instance()
    {
        return $this;
    }

    /**
     * Get the field group from ACF based on the ID given
     *
     * @param $field_group_id
     * @throws Exception
     */
    public static function getFieldsFromGroup($field_group_id)
    {
        self::init();

        $factory = new ACF_Factory($field_group_id);

        $factory->renderWidgets();
    }

    /**
     * Get the field based on the ID given
     *
     * @param $field_id
     * @throws Exception
     */
    public static function getFieldById($field_id)
    {
        self::init();

        $factory = new ACF_Factory($field_id);

        $factory->renderWidget($field_id);
    }

}
