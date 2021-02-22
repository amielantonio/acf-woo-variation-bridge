<?php

namespace ACFBridge\Fields\Choice;

use ACFBridge\Base\ACFInterface\FieldHTML;
use function simplehtmldom_1_5\dump_html_tree;

class ACF_Select extends FieldHTML {

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
        "maxLength" => ""
    ];

    protected $opening_html = "<select";

    protected $closing_html = "</select";

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
