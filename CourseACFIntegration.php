<?php

class CourseACFIntegration
{

    /**
     * Singleton Instance
     *
     * @var CourseACFIntegration
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
    }

    protected function instance()
    {
        return $this;
    }


    protected static function getFieldsFromCourse($course_id)
    {

    }

    protected static function getFieldById($field_id)
    {

    }

    protected static function renderField( $field )
    {

    }

}
