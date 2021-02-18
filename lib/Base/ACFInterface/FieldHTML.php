<?php

namespace ACFBridge\Base\ACFInterface;

abstract class FieldHTML
{
    protected $opening_html = "<input";

    protected $closing_html = ">";

    protected $fieldType;

    protected $html_id;

    protected $html_class;

    protected $placeholder;

    protected $defaultValue;

    protected $is_required;

    protected $is_disabled;

    private $htmlInfo = [];


    protected function build()
    {
        $html = "";
        $html_info = $this->html();

        $html .= $this->opening_html;



        $html .= $this->closing_html;
    }

    protected function html()
    {
        return [
            "type" => $this->checkType(),
        ];
    }

    protected function checkType()
    {
        return $this->fieldType <> "" ? "type='{$this->fieldType}'" : "type='text'";
    }

    protected function defaultValue()
    {
        return $this->defaultValue <> "" ? "value='{$this->defaultValue()}'" : "";
    }

    protected function placeholder()
    {
        return $this->placeholder <> "" ? "placeholder='{$this->placeholder()}'" : "";
    }

    protected function is_required()
    {
        return $this->is_required <> "" ? "required='required'" : "";
    }

    protected function is_disabled()
    {
        return $this->is_disabled <> "" ? "disabled='disabled'" : "";
    }



}
