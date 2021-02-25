<?php

namespace ACFBridge\Fields\Basic;

class ACF_Email extends ACF_Text {

    /**
     * @override $field
     * @var object | array
     */
    protected $field;

    /**
     * @override fieldType
     * @var string
     */
    protected $fieldType = "email";

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
    }

}
