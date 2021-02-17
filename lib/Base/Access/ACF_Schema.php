<?php

namespace ACF\Base\Access;

class ACF_Schema {

    /**
     * Get an ACF field in the database
     *
     * @param $field_id
     * @return object|string
     */
    public function getField( $field_id )
    {
        return $this->getObjectField($field_id);
    }

    /**
     * Get multiple ACF fields in the database
     *
     * @param mixed ...$field_ids
     * @return array
     */
    public function getFields( ...$field_ids )
    {
        $fields = [];

        foreach ($field_ids as $field_id) {
            $fields[] = $this->getObjectField($field_id);
        }

        return $fields;
    }

    /**
     * Get the field object from the database
     *
     * @param $field_id
     * @param bool $with_children
     * @return object|string
     */
    private function getObjectField( $field_id, $with_children = true )
    {
        $field = [];
        $post = get_post($field_id);
        $content = $post->post_content;

        if($post->post_type <> "acf-field" || $post->post_type <> "acf-field-group") return "Error! ID is not an ACF Field" ;

        $field[$field_id] = [
            "field_title" => $post->post_title,
            "excerpt" => $post->post_excerpt,
            "field_name" => $post->post_name,
        ];

        $field[$field_id] = array_merge($field[$field_id], $content);

        if($post->post_type == "acf-field-group" && $with_children) {
            $spawn = [];
            $children = get_children($field_id);
            foreach ($children as $child) {
                $spawn[] = $this->getObjectField($child->ID);
            }

            $field[$field_id] = array_merge($field[$field_id], $spawn);
        }

        return (object) $field;
    }



}
