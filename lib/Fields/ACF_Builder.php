<?php

namespace ACFBridge\Fields;

use ACFBridge\Fields\Basic\ACF_Email;
use ACFBridge\Fields\Basic\ACF_Number;
use ACFBridge\Fields\Basic\ACF_Text;
use ACFBridge\Fields\Basic\ACF_TextArea;
use ACFBridge\Fields\Choice\ACF_Select;
use ACFBridge\Fields\Choice\ACF_TrueFalse;
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

    /**
     * Defaults to type text
     *
     * @var string
     */
    private $type = "text";

    /**
     * Boolean for loop support
     *
     * @var bool
     */
    private $loop_support = false;

    /**
     * Post ID
     *
     * @var int
     */
    private $post_id;

    /**
     * add ctr
     *
     * @var int | null
     */
    private $ctr;

    private $attributes;

    /**
     * Widget options
     *
     * @var mixed
     */
    private $options;

    /**
     * ACF_Builder constructor.
     *
     * @param array $field
     * @param array $options
     */
    public function __construct($field = [], $options = [])
    {
        $this->field = $field;

        $this->options = $options['options'];

        $this->loop_support = isset($options['options']["loop_support"]) ?  $options['options']['loop_support'] : false;

        $this->ctr = isset($options['options']['ctr']) ? $options['options']['ctr'] : false;

        $this->post_id = isset($options['options']['post_id']) ? $options['options']['post_id'] : "";
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
            return $this->$method($wd);
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

        return $textBuilder->loopSupport($this->loop_support, $this->ctr)->post($this->post_id)->render();
    }

    public function buildTextArea($field)
    {
        $textAreaBuilder = new ACF_TextArea($field);

        return $textAreaBuilder->loopSupport($this->loop_support, $this->ctr)->post($this->post_id)->render();
    }

    public function buildNumber($field)
    {
        $textBuilder = new ACF_Number($field);

        return $textBuilder->loopSupport($this->loop_support, $this->ctr)->post($this->post_id)->render();
    }

    public function buildEmail($field)
    {
        $textBuilder = new ACF_Email($field);

        return $textBuilder->loopSupport($this->loop_support, $this->ctr)->post($this->post_id)->render();
    }

    public function buildURL($field)
    {
        $textBuilder = new ACF_Text($field);

        return $textBuilder->loopSupport($this->loop_support, $this->ctr)->post($this->post_id)->render();
    }

    /**
     * Build password
     *
     * @param $field
     * @return string
     */
    public function buildPassword($field)
    {
        $textBuilder = new ACF_Text($field, ["type" => "password"]);

        return $textBuilder->loopSupport($this->loop_support, $this->ctr)->post($this->post_id)->render();
    }

    /**
     * Build date picker
     *
     * @param $field
     * @return string
     */
    public function buildDatePicker($field)
    {
        $datepickerBuilder = new ACF_DatePicker($field);

        return $datepickerBuilder->loopSupport($this->loop_support, $this->ctr)->post($this->post_id)->render();
    }

    /**
     * Build Wysiwyg editor
     *
     * @param $field
     * @return string
     */
    public function buildWysiwyg($field)
    {
        $wysiwygBuilder = new ACF_Wysiwyg($field);

        return $wysiwygBuilder->loopSupport($this->loop_support, $this->ctr)->post($this->post_id)->render();
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

        return $selectBuilder->loopSupport($this->loop_support, $this->ctr)->post($this->post_id)->render();
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

        return $postObjectBuilder->loopSupport($this->loop_support, $this->ctr)->post($this->post_id)->render();
    }

    /**
     * Build a dropdown with posts as choices
     *
     * @param $field
     * @return string
     */
    public function buildTrueFalse($field)
    {
        $trueFalse = new ACF_TrueFalse($field);

        return $trueFalse->loopSupport($this->loop_support, $this->ctr)->post($this->post_id)->render();
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
