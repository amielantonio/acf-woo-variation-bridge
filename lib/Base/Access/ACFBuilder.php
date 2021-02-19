<?php

namespace ACFBridge\Base\Access;

use ACFBridge\Base\ACFInterface\FieldInterface;
use ACFBridge\Fields\Basic\ACF_Text;


class ACFBuilder
{

    private $field;

    public function __construct( $field = "" )
    {
        $this->field = $field;
    }


    public function build( $field = "" )
    {
        $wd = $field <> ""  ? $field : $this->field;

        $method = "build" . $this->widgetLookup($this->field);

        if (!$wd) {
            return false;
        }



        return $this->$method($field);

    }

    public function buildText($field)
    {
        $textBuilder = new ACF_Text();
    }

    public function buildTextarea( $field)
    {

    }

    public function buildNumber($field)
    {

    }

    public function buildEmail($field)
    {

    }

    public function buildURL()
    {

    }

    public function buildPassword($field)
    {

    }

    public function buildSelect()
    {

    }


    /**
     * Lookup array for sticking to widget
     *
     * @param $widget
     * @return mixed
     */
    public function widgetLookup($widget)
    {
        $fields = [
            'text' => 'Text',
            'textarea' => 'TextArea',
            'number' => 'Number',
            'email' => 'Email',
            'url' => 'URL',
            'password' => 'Password',
            'wysiwyg_editor' => 'WEditor',
            'select' => 'Select',
            'checkbox' => 'Checkbox',
            'radio_button' => 'RadioButton',
            'true_false'=> 'TrueFalse',
            'link' => 'Link',
            'post_object' => 'PostObject',
        ];

        return $fields[$widget];
    }

}
