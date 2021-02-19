<?php

namespace ACFBridge\Fields\Basic;

use ACFBridge\Base\ACFInterface\FieldHTML;

class ACF_Text extends FieldHTML {

    protected $field;

    protected $fieldType = "Text";


    public function __construct($field)
    {
        parent::__construct($field);
    }

}
