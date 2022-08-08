<?php

namespace ACFBridge\Fields\Choice;

use ACFBridge\Base\ACFInterface\FieldHTML;

class ACF_TrueFalse extends FieldHTML
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

    protected $baseClass = "bridge-switch-container";

    public function __construct($field, array $options = [])
    {
        parent::__construct($field, $options);
    }

    protected function valueHTML()
    {
        if($this->html_value == "on") {
            return "checked='checked'";
        }

        return "";
    }

    public function buildField()
    {
        $htmlInfo = $this->html();

        $html = "<input type='hidden' {$htmlInfo['name']} value='off'>
                 <div class='bridge-switch'>
                    <input type='checkbox' {$htmlInfo['name']} {$htmlInfo['required']} {$htmlInfo['wrappers']} {$htmlInfo['disabled']} {$htmlInfo['value']}>
                    <span class='bridge-switch__slider'> </span>
                </div>";

        return $html;
    }


}

