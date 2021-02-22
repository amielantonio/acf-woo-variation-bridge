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

    public function buildParentHTML($childHTML);

}
