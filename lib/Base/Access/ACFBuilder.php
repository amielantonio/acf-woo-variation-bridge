<?php

namespace ACFBridge\Base\Access;

use ACFBridge\Base\ACFInterface\FieldInterface;
use ACFBridge\Fields\Basic\ACF_Text;


class ACFBuilder
{

    public function build($widget)
    {
        $method = "" . $this->widgetLookup($widget);
    }

    public function buildText($field)
    {


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
