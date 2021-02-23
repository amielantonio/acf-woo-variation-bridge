<?php

namespace ACFBridge\Fields\Relational;

use ACFBridge\Fields\Choice\ACF_Select;

class ACF_PostObject extends ACF_Select {

    /**
     * @override $field
     * @var object | array
     */
    protected $field;

    /**
     * @override fieldType
     * @var string
     */
    protected $fieldType = "select";

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
        "maxLength" => "",
        "post_type" => "",
    ];



    /**
     * ACF_Text constructor.
     *
     * @param $field
     * @param array $options
     */
    public function __construct($field, $options = [])
    {
        parent::__construct($field, $options);

    }

    /**
     * Build Select
     *
     * @return string
     */
    public function buildField()
    {
        $htmlInfo = $this->html();
        $oHtml = $this->opening_html;
        $cHtml = $this->closing_html;
        $choices = $this->choices();

        $html = "
            {$oHtml} {$htmlInfo['wrappers']}
                {$htmlInfo['required']} 
                {$htmlInfo['disabled']}
                {$htmlInfo['mulitple']}>
                {$choices}            
            {$cHtml}
        ";
        return $html;
    }


}