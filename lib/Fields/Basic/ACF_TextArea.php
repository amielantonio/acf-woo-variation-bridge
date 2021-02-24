<?php

namespace ACFBridge\Fields\Basic;

use ACFBridge\Base\ACFInterface\FieldHTML;

class ACF_TextArea extends FieldHTML {

    protected $field;

    protected $fieldType = "textarea";

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

    protected $opening_html = "<textarea";

    protected $closing_html = "</textarea>";

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