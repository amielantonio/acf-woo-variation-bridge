<?php

namespace ACFBridge\Base\ACFInterface;

interface FieldInterface {

    /**
     * Builds the HTML for the field
     *
     * @return string
     */
    public function build();

    /**
     * Renders the HTML Build
     *
     * @return string
     */
    public function render();

    /**
     * Map out values from ACF to Field integration
     *
     * @return mixed
     */
    public function map();

    /**
     *
     *
     * @return string
     */
    public function buildField();

    /**
     * Build the wrapping html of the field
     *
     * @param $childHTML
     * @return string
     */
    public function buildWrapper($childHTML);

    /**
     * fill up the properties of the html
     *
     * @return void
     */
    public function fill();

}
