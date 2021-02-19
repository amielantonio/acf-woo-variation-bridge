<?php

namespace ACFBridge\Base\ACFInterface;

use ACFBridge\Base\ACFInterface\FieldInterface;

abstract class FieldHTML implements FieldInterface
{
    /**
     * Default opening html, since most form widgets starts with input, this would be the default
     *
     * @var string
     */
    protected $opening_html = "<input";

    /**
     * Default closing html, the default closing html for input types
     *
     * @var string
     */
    protected $closing_html = " />";

    /**
     * The field input type
     *
     * @var string
     */
    protected $fieldType;

    /**
     * The HTML ID of the form widget
     *
     * @var string
     */
    protected $html_id;

    /**
     * The HTML Class of the form widget
     *
     * @var string
     */
    protected $html_class;

    /**
     * The placeholder for the form widget
     *
     * @var string
     */
    protected $placeholder;

    /**
     * The default value of the form, contains a string or an int for number input types
     *
     * @var string | int
     */
    protected $defaultValue;

    /**
     * If the form is required by default
     *
     * @var string | bool
     */
    protected $is_required;

    /**
     * If the form is disabled by default
     *
     * @var
     */
    protected $is_disabled;

    /**
     * The current field that is being mutated
     *
     * @var string
     */
    protected $field;

    /**
     * The html info of the field that was mutated.
     *
     * @var array
     */
    private $htmlInfo = [];


    /**
     * FieldHTML constructor.
     *
     *
     * @param array | object $field
     */
    public function __construct( $field )
    {
        $this->field = $field;
    }


    public function build()
    {
        $html = "";
        $html_info = $this->html();

        $html .= $this->opening_html;



        $html .= $this->closing_html;
    }

    protected function html()
    {
        return [
            "type" => $this->fieldTypeHTML(),
        ];
    }


    protected function fieldTypeHTML()
    {
        return $this->fieldType <> "" ? "type='{$this->fieldType}'" : "type='text'";
    }

    protected function defaultValueHTML()
    {
        return $this->defaultValue <> "" ? "value='{$this->defaultValue}'" : "";
    }

    protected function placeholderHTML()
    {
        return $this->placeholder <> "" ? "placeholder='{$this->placeholder}'" : "";
    }

    protected function requiredHTML()
    {
        return $this->is_required <> "" ? "required='required'" : "";
    }

    protected function disabledHTML()
    {
        return $this->is_disabled <> "" ? "disabled='disabled'" : "";
    }

    private function map()
    {

    }

}
