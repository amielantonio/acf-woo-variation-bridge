<?php

namespace ACFBridge\Fields\Basic;

use ACFBridge\Base\ACFInterface\FieldHTML;

class ACF_TextArea extends FieldHTML {

    /**
     * Fields
     *
     * @var
     */
    protected $field;

    /**
     * text area type
     *
     * @var string
     */
    protected $fieldType = "textarea";

    /**
     * defaults of acf
     *
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
     * textarea opening html
     *
     * @var string
     */
    protected $opening_html = "<textarea";

    /**
     * Textarea closing html
     *
     * @var string
     */
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


        $html = "
            {$oHtml} {$htmlInfo['wrappers']}
                {$htmlInfo['required']} 
                {$htmlInfo['disabled']}
                {$htmlInfo['mulitple']}
                {$htmlInfo['name']}>
                    {$htmlInfo['value']}                
            {$cHtml}
        ";
        return $html;
    }

}
