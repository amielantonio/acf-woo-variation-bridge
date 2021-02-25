<?php

namespace ACFBridge\Fields;

use ACFBridge\Fields\Basic\ACF_Email;
use ACFBridge\Fields\Basic\ACF_Number;
use ACFBridge\Fields\Basic\ACF_Text;
use ACFBridge\Fields\Basic\ACF_TextArea;
use ACFBridge\Fields\Choice\ACF_Select;
use ACFBridge\Fields\jQuery\ACF_DatePicker;
use ACFBridge\Fields\jQuery\ACF_Wysiwyg;
use ACFBridge\Fields\Relational\ACF_PostObject;
use BuildException;

class ACF_Builder
{

    /**
     * Field info
     *
     * @var array
     */
    private $field;

    private $type = "text";

    /**
     * ACFBuilder constructor.
     *
     * @param array $field
     */
    public function __construct($field = [])
    {
        $this->field = $field;
    }


    /**
     * Create a build HTML of the field info given
     *
     * @param array | object $field
     * @return bool
     * @throws BuildException
     */
    public function build( $field = [] )
    {
        $wd = !empty($field)  ? $field : $this->field;

        //reset($wd)['content']
        $this->type = $type = reset($wd)['content']['type'];

        $method = "build" . $this->widgetLookup($type);

        if (!$wd && $this->widgetLookup($type)) {
            return false;
        }

        if(method_exists($this, $method)) {
            return $this->$method($field);
        } else {
            throw new BuildException("Build Failed, cannot build the widget you are referring to");

        }
    }


    /**
     * Builds the widget with typed "text"
     *
     * @param $field
     * @return string
     */
    public function buildText($field)
    {
        $textBuilder = new ACF_Text($field);

        return $textBuilder->render();
    }

    public function buildTextArea($field)
    {
        $textAreaBuilder = new ACF_TextArea($field);

        return $textAreaBuilder->render();
    }

    public function buildNumber($field)
    {
        $textBuilder = new ACF_Number($field);

        return $textBuilder->render();
    }

    public function buildEmail($field)
    {
        $textBuilder = new ACF_Email($field);

        return $textBuilder->render();
    }

    public function buildURL($field)
    {
        $textBuilder = new ACF_Text($field);

        return $textBuilder->render();
    }

    public function buildPassword($field)
    {
        $textBuilder = new ACF_Text($field, ["type" => "password"]);

        return $textBuilder->render();
    }

    public function buildDatePicker($field)
    {
        $datepickerBuilder = new ACF_DatePicker($field);

        return $datepickerBuilder->render();
    }

    public function buildWysiwyg($field)
    {
        $wysiwygBuilder = new ACF_Wysiwyg($field);

        return $wysiwygBuilder->render();
    }



    /**
     * Builds a dropdown widget
     *
     * @param $field
     * @return string
     */
    public function buildSelect($field)
    {
        $selectBuilder = new ACF_Select($field);

        return $selectBuilder->render();
    }

    /**
     * Build a dropdown with posts as choices
     *
     * @param $field
     * @return string
     */
    public function buildPostObject($field)
    {
        $postObjectBuilder = new ACF_PostObject($field);

        return $postObjectBuilder->render();
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
            'wysiwyg' => 'Wysiwyg',
            'select' => 'Select',
            'checkbox' => 'Checkbox',
            'radio_button' => 'RadioButton',
            'true_false'=> 'TrueFalse',
            'link' => 'Link',
            'post_object' => 'PostObject',
            'date_picker' => 'DatePicker'
        ];

        return $fields[$widget];
    }

}
