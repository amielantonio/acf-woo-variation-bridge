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
     * Post ID
     *
     * @var int
     */
    protected $post_id;

    /**
     * The field name
     *
     * @var
     */
    protected $name;

    /**
     * Unfiltered name
     *
     * @var string
     */
    protected $_name;

    /**
     * The HTML ID of the form widget
     *
     * @var string
     */
    protected $html_id;


    /**
     * The unfiltered version of the html id
     *
     * @var string
     */
    protected $html_id_unfiltered;

    /**
     * The HTML Class of the form widget
     *
     * @var array
     */
    protected $html_class = [];

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
     * The html value that should be rendered. This value can be the default Value or the
     * value that was from the database.
     *
     * @var string | int
     */
    protected $html_value;

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
     * Check if the form accepts multiple
     *
     * @var string
     */
    protected $multiple;

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
     * Attribute variables
     *
     * @var array
     */
    protected $attributes = [];

    /**
     * HTML Data attributes
     *
     * @var array
     */
    protected $dataAttributes = [];

    /**
     *
     *
     * @var array
     */
    protected $options = [];

    /**
     * Loop support for widgets that has an array as the name
     *
     * @var bool
     */
    private $loop_support = false;

    /**
     * counter for the loop that defaults to 0
     *
     * @var int
     */
    private $ctr = 0;

    protected $baseClass;


    /**
     * FieldHTML constructor.
     *
     *
     * @param array | object $field
     * @param array $options
     */
    public function __construct($field, $options = [])
    {
        global $post;
        $this->field = reset($field);
        $this->options = $options;
        $this->acf_default = $this->map();
        $this->fill();

        $this->post_id = $post;
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
        $dataAttributes = $this->createDataAttributesHTML();

        $html = "{$oHtml} {$this->htmlInfo['type']} {$this->htmlInfo['wrappers']} {$this->htmlInfo['placeholder']} {$this->htmlInfo['name']} {$dataAttributes}
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
        $openingClass = $this->name . "_field";
        $opening = "<div class='bridge-widget {$openingClass}'>";
        $closing = "</div>";
        $label = $this->label;
        $labelFor = ($this->html_id_unfiltered <> "" ) ? $this->html_id : $this->name;

        $description = $this->description;
        $descriptionHTML = $description <> "" ? "<div class='bridge-description'>$description</div>" : "";
        $requiredHTML = $this->buildRequiredHTML();

        return "{$opening}
                    <div class='bridge-label'>
                        <label for='{$labelFor}'>{$label} {$requiredHTML}</label>
                    </div>
                    <div class='bridge-input {$this->baseClass}'>
                        {$childHTML}
                    </div>
                    {$descriptionHTML}
                {$closing}";
    }

    /**
     * Build the required html
     *
     * @return string
     */
    public function buildRequiredHTML()
    {
        if(!$this->is_required){
            return "";
        }

        return "<span class='bridge-required'>*</span>";
    }



    public function buildSuffixHTML()
    {

    }

    public function buildPrefixHTML()
    {

    }

    /**
     * Render the
     *
     * @return string|void
     */
    public function render()
    {
        $this->html_value = $this->getValue();

        return $this->build();
    }

    /**
     *  HTML
     *
     * @return array
     */
    protected function html()
    {
        return [
            "name" => $this->nameHTML(),
            "type" => $this->fieldTypeHTML(),
            "wrappers" => $this->wrappers(),
            "placeholder" => $this->placeholderHTML(),
            "required" => $this->requiredHTML(),
            "value" => $this->valueHTML(),
            "disabled" => $this->disabledHTML(),
            "multiple" => $this->is_multiple(),
            "data_attributes" => $this->createDataAttributesHTML(),
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

    /**
     * Get default value html
     *
     * @return string
     */
    protected function defaultValueHTML()
    {
        return $this->defaultValue <> "" ? "value='{$this->defaultValue}'" : "";
    }

    /**
     * Value HTML that gets the post meta value or the default value.
     *
     * @return string
     */
    protected function valueHTML()
    {
        return "value='{$this->html_value}'";
    }

    /**
     * Get the value of the value attribute of the field
     */
    protected function getValue()
    {
        $dbValue = get_post_meta($this->post_id, $this->_name);


        if(!$dbValue) {
            return "";
        }

        if(count($dbValue ) > 0 ){
            $dbValue = $dbValue[0];
        }

        $defaultValue = $this->defaultValue;

        return $dbValue <> "" ? $dbValue : $defaultValue;
    }


    /**
     * Create HTML for the name attribute
     *
     * @return string
     */
    protected function nameHTML()
    {
        return $this->name <> "" ? "name='{$this->name}'" : "";
    }

    /**
     * Create HTML for the placeholder attribute
     *
     * @return string
     */
    protected function placeholderHTML()
    {
        return $this->placeholder <> "" ? "placeholder='{$this->placeholder}'" : "";
    }

    /**
     * Create HTML for the required attribute
     *
     * @return string
     */
    protected function requiredHTML()
    {
        return $this->is_required > 0 ? "required='required'" : "";
    }

    /**
     * Create HTML for the disabled HTML
     *
     * @return string
     */
    protected function disabledHTML()
    {
        return $this->is_disabled > 0 ? "disabled='disabled'" : "";
    }

    /**
     * create the classes and id of the field
     *
     * @return string
     */
    protected function wrappers()
    {
        $width = $this->width <> 0 && $this->width <> ""
            ? " width='{$this->width}'"
            : "";

        $classes = implode(" ", $this->html_class);


        $id = ($this->html_id_unfiltered == "" ) ? $this->name : $this->html_id;

        return "class='{$classes}' id='{$id}'{$width}";
    }

    /**
     *
     *
     * @return string
     */
    protected function choices()
    {
        $html = "";

        //Add base HTML as placeholder
        $html .= "<option value=''>Select {$this->label}</option>";

        //Check for binding values
        $dbValue = $this->getValue();

        echo "{$this->label}: {$this->_name} - {$dbValue} <br />";

        //Get choices
        foreach ($this->choices as $key => $value) {

            $valHTML = $dbValue == $key ? " selected='selected'" : "";

            $html .= "<option value='{$key}'{$valHTML}>{$value}</option>";
        }

        return $html;
    }

    /**
     *
     *
     * @return string
     */
    protected function is_multiple()
    {
        return $this->multiple > 0 ? "multiple='multiple'" : "";
    }

    /**
     * Add data attribute support
     *
     * @param $key
     * @param string $value
     * @return $this
     */
    public function addDataAttribute($key, $value = "")
    {
        if(is_array($key)){
            $this->dataAttributes = array_merge($this->dataAttributes, $key);
        } else {
            $this->dataAttributes[$key] = $value;
        }

        return $this;
    }

    /**
     * Create the html format of the data attribute
     *
     * @return string
     */
    private function createDataAttributesHTML()
    {
        $html = "";

        /*
         * Make sure that we wont be returning any
         * random html code when data attribute is empty
         */
        if (!empty($this->dataAttributes)) {
            foreach ($this->dataAttributes as $key => $attribute) {
                $html .= "data-{$key}='{$attribute}'";
            }

            return $html;
        }
    }

    /**
     * Add a class to the html
     *
     * @param $class
     * @return $this
     */
    public function addClass($class)
    {
        if (is_array($class)) {
            $this->html_class = array_merge($this->html_class, $class);
        } else {
            $this->html_class[] = $class;
        }

        return $this;
    }

    /**
     * Add the post ID inside the widget
     *
     * @param $post_id
     * @return $this
     */
    public function post($post_id)
    {


        $this->post_id = $post_id;

        /*
         * Add data attribute to the post ID.
         * This will allow users to add more
         * options and customization in the frontend
         * or javascript.
         */
        $this->addDataAttribute('post_id', $post_id);

        return $this;
    }


    /**
     * Creates the ID for the html
     *
     * @param int $attrib
     * @param string $prop
     * @return string
     */
    public function createAttribLoop($attrib, $prop = "")
    {
        if ($this->loop_support) {

            $unfilteredProp = "_{$prop}";

            $this->$unfilteredProp = $attrib;

            return $attrib = $attrib . "[{$this->ctr}]";
        }

        return $attrib;
    }

    /**
     * Loop support
     *
     * @param bool $loop_support
     * @param int $ctr
     * @return $this
     */
    public function loopSupport($loop_support = false, $ctr = 0)
    {
        $this->loop_support = $loop_support;

        $this->ctr = $ctr;

        $this->html_id_unfiltered = $this->html_id;

        $this->html_id = isset($this->options['html_id'])
            ? $this->createAttribLoop($this->options['id'])
            : $this->createAttribLoop($this->acf_default['wrapper']['id']);

        $this->name = isset($this->options['name'])
            ? $this->createAttribLoop($this->options['excerpt'], "name")
            : $this->createAttribLoop($this->acf_default['excerpt'], "name");

        return $this;
    }


    /**
     * Set HTML ID
     *
     * @param $id
     * @return $this
     */
    public function setHtmlID($id)
    {
        $this->html_id_unfiltered = $this->html_id = $id;


        return $this;
    }

    /**
     * map out the fields base object
     *
     * @return array|bool|mixed
     */
    public function map()
    {
        $defaults = [];
        if (empty($this->field)) return false;

        foreach ($this->field as $key => $value) {
            if ($key <> "content") {
                $defaults[$key] = $value;
            } else {
                foreach ($value as $content_key => $content_value) {
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
        $this->fieldType = $this->setFill('type');
        $this->description = $this->setFill('description');
        $this->is_required = $this->setFill('required');
        $this->defaultValue = $this->setFill('value');
        $this->placeholder = $this->setFill('placeholder');
        $this->choices = $this->setFill('choices');
        $this->multiple = $this->setFill('multiple');
        $this->html_class = isset($this->options['classes']) && count($this->options) > 0? $this->options['classes'] : explode(" ", $this->acf_default['wrapper']['class']);

        $this->html_id_unfiltered = $this->html_id;

        $this->html_id = isset($this->options['html_id'])
            ? $this->createAttribLoop($this->options['id'])
            : $this->createAttribLoop($this->acf_default['wrapper']['id']);

        $this->name = isset($this->options['name'])
            ? $this->createAttribLoop($this->options['excerpt'])
            : $this->createAttribLoop($this->acf_default['excerpt']);

        $this->html_value = $this->getValue();
    }


    /**
     * Sets the fill value
     *
     * @param $name
     * @param string $default_value
     * @return mixed|string
     */
    public function setFill($name, $default_value = "")
    {
        if( isset($this->options[$name]) && count($this->options) > 0  ) {
            return $this->options['label'];
        }

        if( isset($this->acf_default[$name])) {
            return $this->acf_default[$name];
        }

        if( $default_value <> "" ){
            return $default_value;
        }

        return "";
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
        if (property_exists($this, $name)) {
            $this->fillable[$name] = $value;
        } else {
            $this->$name = $value;
        }
    }

    /**
     * Set the choices for the dropdown
     *
     * @param $choices
     */
    public function setChoices($choices)
    {
        $this->choices = $choices;
    }

    /**
     * add choices to the html
     *
     * @param $key
     * @param $choice
     */
    public function addChoices($key, $choice)
    {
        if (is_array($key)) {
            $this->choices = array_merge($this->choices, $key);
        } else {
            $this->choices[$key] = $choice;
        }
    }

}
