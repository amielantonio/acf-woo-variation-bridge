<?php

namespace ACFBridge\Fields\Basic;

use ACFBridge\Base\ACFInterface\FieldHTML;

class ACF_Text extends FieldHTML
{
    /**
     * @override $field
     * @var object | array
     */
    protected $field;

    /**
     * @override fieldType
     * @var string
     */
    protected $fieldType = "text";

    /**
     * @ovverride acf_default
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
