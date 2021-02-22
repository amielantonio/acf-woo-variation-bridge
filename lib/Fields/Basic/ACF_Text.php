<?php

namespace ACFBridge\Fields\Basic;

use ACFBridge\Base\ACFInterface\FieldHTML;

class ACF_Text extends FieldHTML {

    protected $field;

    protected $fieldType = "text";

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


    public function __construct($field)
    {
        parent::__construct($field);
    }


    public function build()
    {
        

    }



}
