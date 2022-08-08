<?php

namespace ACFBridge\Fields\Choice;

use ACFBridge\Base\ACFInterface\FieldHTML;


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
        "maxLength" => "",
        "multiple" => 0,
        "choices" => []
    ];

    protected $opening_html = "<select";

    protected $closing_html = "</select>";

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
        //Add the select2 for multiple selection
        if($this->multiple) {
            $this->addClass('select2-bridge');
        }


        $htmlInfo = $this->html();
        $oHtml = $this->opening_html;
        $cHtml = $this->closing_html;
        $choices = $this->choices();

        $name = $this->multiple ? "name='{$this->name}[]'" : $htmlInfo['name'];

        $html = "
            {$oHtml} {$htmlInfo['wrappers']}
                {$htmlInfo['required']}
                {$htmlInfo['disabled']}
                {$htmlInfo['multiple']}
                {$name}>
                {$choices}
            {$cHtml}
        ";

        return $html;
    }

}
