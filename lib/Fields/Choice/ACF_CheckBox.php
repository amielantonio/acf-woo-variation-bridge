<?php

namespace ACFBridge\Fields\Choice;

use ACFBridge\Base\ACFInterface\FieldHTML;

class ACF_CheckBox extends FieldHTML
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
    protected $fieldType = "checkbox";

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
        "maxLength" => "",
        "choices" => []
    ];



    public function __construct($field, array $options = [])
    {
        parent::__construct($field, $options);
    }

    public function buildField()
    {
        $html = "";
        $innerHtml = "";

        foreach($this->choices as $choice){

        }
    }


}

