<?php

namespace ACFBridge\Fields;

use ACFBridge\Fields\Basic\ACF_Text;
use mysql_xdevapi\Exception;

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
     * @throws \Exception
     */
    public function build( $field = [] )
    {
        $wd = !empty($field)  ? $field : $this->field;

        //reset($wd)['content']
        $this->type = $type = reset($wd)['content']['type'];

        $method = "build" . $this->widgetLookup($type);

        if (!$wd) {
            return false;
        }

        if(method_exists($this, $method)) {
            return $this->$method($field);
        } else {
            throw new \Exception("Build Failed, cannot build the widget you are referring to");
        }
    }


    /**
     * Builds the widget with typed "text"
     *
     * @param $field
     * @return string|void
     */
    public function buildText($field)
    {
        $textBuilder = new ACF_Text($field);

        return $textBuilder->render();
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
