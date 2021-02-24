<?php

namespace ACFBridge\Base\ACFInterface;

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
     * Field choices for select type
     *
     * @var
     */
    protected $choices;

    /**
     * sets the width of the field
     *
     * @var int | float
     */
    protected $width;

    /**
     * Field Label
     *
     * @var string
     */
    protected $label;

    /**
     * Field description
     *
     * @var string
     */
    protected $description;

    /**
     * The html info of the field that was mutated.
     *
     * @var array
     */
    private $htmlInfo = [];

    /**
     * Default ACF Fields
     *
     * @var array|bool|mixed
     */
    protected $acf_default = [];

    /**
     * Fillable variables
     *
     * @var array
     */
   protected $fillable = [];


   protected $options = [];


    /**
     * FieldHTML constructor.
     *
     *
     * @param array | object $field
     * @param array $options
     */
    public function __construct( $field, $options = [] )
    {
        $this->field = reset($field);
        $this->options = $options;
        $this->acf_default = $this->map();
        $this->fill();
    }

    /**
     * return the html build
     *
     * @return string
     */
    public function build()
    {
        return $this->buildWrapper($this->buildField());
    }

    /**
     * Build the field: Defaults to text field type
     *
     * @return string
     */
    public function buildField()
    {
        $this->htmlInfo = $this->html();
        $oHtml = $this->opening_html;
        $cHtml = $this->closing_html;

        $html = "{$oHtml} {$this->htmlInfo['type']} {$this->htmlInfo['wrappers']} {$this->htmlInfo['placeholder']} 
                {$this->htmlInfo['required']} 
                {$this->htmlInfo['value']} 
                {$this->htmlInfo['disabled']}
            {$cHtml}
        ";

        return $html;
    }

    /**
     * Build the parent wrapper html
     *
     * @param $childHTML
     * @return string
     */
    public function buildWrapper($childHTML)
    {
        $opening = "<div>";
        $closing = "</div>";
        $label = $this->label;
        $description = $this->description;
        $descriptionHTML = $description <> "" ? "<span>$description</span>" : "";

        return "{$opening}
                    <div class='bridge-label'>
                        <label>{$label}</label>
                        {$descriptionHTML}
                    </div>
                    <div class='bridge-input'>
                        {$childHTML}
                    </div>
                {$closing}";
    }

    /**
     * Render the
     *
     * @return string|void
     */
    public function render()
    {
        echo $this->build();
    }

    protected function html()
    {
        return [
            "type" => $this->fieldTypeHTML(),
            "wrappers" => $this->wrappers(),
            "placeholder" => $this->placeholderHTML(),
            "required" => $this->requiredHTML(),
            "value" => $this->defaultValueHTML(),
            "disabled" => $this->disabledHTML(),
            "multiple" => $this->is_multiple()
        ];
    }

    /**
     * Field HTML
     *
     * @return string
     */
    protected function fieldTypeHTML()
    {
        return $this->fieldType <> "" ? "type='{$this->fieldType}'" : "type='text'";
    }

    protected function defaultValueHTML()
    {
        return $this->defaultValue <> "" ? "value='{$this->defaultValue}'" : "";
    }


    protected function getValue()
    {
        
    }


    protected function placeholderHTML()
    {
        return $this->placeholder <> "" ? "placeholder='{$this->placeholder}'" : "";
    }

    protected function requiredHTML()
    {
        return $this->is_required > 0 ? "required='required'" : "";
    }

    protected function disabledHTML()
    {
        return $this->is_disabled > 0 ? "disabled='disabled'" : "";
    }

    protected function wrappers()
    {
        $width = $this->width <> 0 && $this->width <> ""
            ? " width='{$this->width}'"
            : "";

        return "class='{$this->html_class}' id='{$this->html_id}'{$width}";
    }

    protected function choices()
    {
        $html = "";
        foreach($this->choices as $key => $value) {
            $html .= "<option value='{$key}'>{$value}</option>";
        }

        return $html;
    }

    protected function is_multiple()
    {
        return $this->is_disabled > 0 ? "multiple='multiple'" : "";
    }



    public function map()
    {
        $defaults = [];
        if(empty($this->field)) return false;

        foreach($this->field as $key => $value) {
            if($key <> "content") {
                $defaults[$key] = $value;
            } else {
                foreach($value as $content_key => $content_value) {
                    $defaults[$content_key] = $content_value;
                }
            }

        }

        return $defaults;
    }

    /**
     * Fill values of the HTML
     */
    public function fill()
    {
        $this->label = isset($this->options['label']) ? $this->options['label'] : $this->acf_default['field_title'];
        $this->excerpt = isset($this->options['excerpt']) ? $this->options['excerpt'] : $this->acf_default['excerpt'];
        $this->fieldType = isset($this->options['type']) ? $this->options['type'] : $this->acf_default['type'];
        $this->description = isset($this->options['description']) ? $this->options['description'] : $this->acf_default['instructions'];
        $this->is_required = isset($this->options['required']) ? $this->options['required'] : $this->acf_default['required'];
        $this->html_class = isset($this->options['classes']) ? $this->options['classes'] : $this->acf_default['wrapper']['class'];
        $this->html_id = isset($this->options['html_id']) ? $this->options['id'] : $this->acf_default['wrapper']['id'];
        $this->defaultValue = isset($this->options['value']) ? $this->options['value'] : $this->acf_default['default_value'];
        $this->placeholder = isset($this->options['placeholder']) ? $this->options['placeholder'] : $this->acf_default['placeholder'];
        $this->choices = isset($this->options['choices']) ? $this->options['choices'] : $this->acf_default['choices'];
    }


    /*----------------------------------------------
     * Getters and Setters
     *---------------------------------------------
     */

    /**
     * Sets a custom variable when the property does not exists
     *
     * @param $name
     * @return mixed
     */
    public function __get($name)
    {
        return $this->$name;
    }

    /**
     * Sets a fillable variable or a custom variable if the property does not exists
     *
     * @param $name
     * @param $value
     */
    public function __set($name, $value)
    {
        if(property_exists($this, $name)) {
            $this->fillable[$name] = $value;
        } else {
            $this->$name = $value;
        }
    }

    public function setChoices($choices)
    {
        $this->choices = $choices;
    }


}
