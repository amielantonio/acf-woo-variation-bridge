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



    public function __construct($field, array $options = [])
    {
        parent::__construct($field, $options);
    }

    public function buildField()
    {
        $htmlInfo = $this->html();

        $html = "<input type='hidden' {$htmlInfo['name']} value='0'>
                 <div>
                    <div>
                        <input type='checkbox' {$htmlInfo['required']} {$htmlInfo['wrappers']} {$htmlInfo['disabled']}>
                    </div>
                    <div class=''>
                        <span></span>
                    </div>
                </div>";

        return $html;
    }


}

