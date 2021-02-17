<?php

namespace ACFBridge\Base\Access;

class ACF_Factory
{
    private $allowedFields = [
        'text',
        'textarea',
        'number',
        'email',
        'url',
        'password',
        'wysiwyg_editor',
        'select',
        'checkbox',
        'radio_button',
        'true_false',
        'link',
        'post_object',
    ];


    public function __set($name, $value)
    {
        // TODO: Implement __set() method.
    }

    public function __get($name)
    {
        // TODO: Implement __get() method.
    }


}
