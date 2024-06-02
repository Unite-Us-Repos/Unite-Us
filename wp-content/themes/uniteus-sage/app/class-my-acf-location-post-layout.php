<?php

if( ! defined( 'ABSPATH' ) ) exit;

class My_ACF_Location_Post_Layout extends ACF_Location {

    public function initialize() {
        $this->name = 'post_layout';
        $this->label = __( "Post Layout", 'acf' );
        $this->object_category = 'post';
        $this->object_type = 'post';
    }

    public function get_values( $rule ) {
        $choices = [
            'gated' => 'Gated',
            'download' => 'Download',
        ];

        return $choices;
    }

    public function match( $rule, $screen, $field_group ) {
        $post_id = '';
        // Check screen args for "post_id" which will exist when editing a post.
        // Return false for all other edit screens.
        if( isset($screen['post_id']) ) {
            $post_id = $screen['post_id'];
        } else {
            return false;
        }

        $layout = get_field('layout', $post_id);

        if( !$layout ) {
            return false;
        }

        // Compare the Post's author attribute to rule value.
        $result = ( $layout == $rule['value'] );

        //echo $result; die();

        return $result;
    }
}
