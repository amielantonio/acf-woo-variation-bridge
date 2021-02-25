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

    /**
     * Defaults to type text
     *
     * @var string
     */
    private $type = "text";


    private $loop_support = false;

    private $ctr;

    /**
     * ACF_Builder constructor.
     *
     * @param array $field
     * @param bool $loop_support
     * @param int $ctr
     */
    public function __construct($field = [], $loop_support = false, $ctr = 0)
    {
        $this->field = $field;

        $this->loop_support = $loop_support;

        $this->ctr = $ctr;
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

        return $textBuilder->loopSupport($this->loop_support, $this->ctr)->render();
    }

    public function buildTextArea($field)
    {
        $textAreaBuilder = new ACF_TextArea($field);

        return $textAreaBuilder->loopSupport($this->loop_support, $this->ctr)->render();
    }

    public function buildNumber($field)
    {
        $textBuilder = new ACF_Number($field);

        return $textBuilder->loopSupport($this->loop_support, $this->ctr)->render();
    }

    public function buildEmail($field)
    {
        $textBuilder = new ACF_Email($field);

        return $textBuilder->loopSupport($this->loop_support, $this->ctr)->render();
    }

    public function buildURL($field)
    {
        $textBuilder = new ACF_Text($field);

        return $textBuilder->loopSupport($this->loop_support, $this->ctr)->render();
    }

    /**
     * Build password
     *
     * @param $field
     * @return string|void
     */
    public function buildPassword($field)
    {
        $textBuilder = new ACF_Text($field, ["type" => "password"]);

        return $textBuilder->loopSupport($this->loop_support, $this->ctr)->render();
    }

    /**
     * Build date picker
     *
     * @param $field
     * @return string|void
     */
    public function buildDatePicker($field)
    {
        $datepickerBuilder = new ACF_DatePicker($field);

        return $datepickerBuilder->loopSupport($this->loop_support, $this->ctr)->render();
    }

    /**
     * Build Wysiwyg editor
     *
     * @param $field
     * @return string|void
     */
    public function buildWysiwyg($field)
    {
        $wysiwygBuilder = new ACF_Wysiwyg($field);

        return $wysiwygBuilder->loopSupport($this->loop_support, $this->ctr)->render();
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

        return $selectBuilder->loopSupport($this->loop_support, $this->ctr)->render();
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

        return $postObjectBuilder->loopSupport($this->loop_support, $this->ctr)->render();
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
            'raio_button' => 'RadioButton',
            'true_false'=> 'TrueFalse',
            'link' => 'Link',
            'post_object' => 'PostObject',
            'date_picker' => 'DatePicker'
        ];

        return $fields[$widget];
    }

}
