<?php

namespace ACFBridge\Fields\jQuery;

use ACFBridge\Fields\Basic\ACF_TextArea;

class ACF_Wysiwyg extends ACF_TextArea
{
    /**
     * @override $fields
     * @var object |array
     */
    protected $field;

    /**
     * @override $fieldType;
     * @var string
     */
    protected $fieldType = "date_picker";

    /**
     * @override acf_default
     * @var array
     */
    protected $acf_default = [
        "field_title" => "",
        "excerpt" => "",
        "type" => "text",
        "required" => 0,
        "width" => "",
        "class" => "",
        "id" => "",
        "default_value" => "",
        "placeholder" => "",
        "maxLength" => ""
    ];

    /**
     * ACF_Text constructor.
     *
     * @param array $options
     * @param $field
     */
    public function __construct($field, $options = [])
    {
        parent::__construct($field, $options);
        $this->addClass('wysiwyg_editor');
    }

}