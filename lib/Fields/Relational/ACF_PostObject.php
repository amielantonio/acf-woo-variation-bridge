<?php

namespace ACFBridge\Fields\Relational;

use ACFBridge\Fields\Choice\ACF_Select;
use WP_Query;

class ACF_PostObject extends ACF_Select {

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
        "post_type" => "",
    ];



    /**
     * ACF_Text constructor.
     *
     * @param $field
     * @param array $options
     */
    public function __construct($field, $options = [])
    {
        parent::__construct($field, $options);
        $this->getPostObjectChoices();
    }

    /**
     * Create a post_object choices, then sets it as the choices for the select dropdown
     */
    public function getPostObjectChoices()
    {
        $post_type = $this->field['content']['post_type'][0];

        $choices = [];
        $args  = [
            'post_type' => $post_type,
            'order' => 'ASC',
            'posts_per_page' => -1,
            'orderby' => 'title'
        ];

        $query = new WP_Query($args);

        foreach($query->posts as $post) {
            $choices[$post->ID] = $post->post_title;
        }


        $this->setChoices($choices);
    }

}