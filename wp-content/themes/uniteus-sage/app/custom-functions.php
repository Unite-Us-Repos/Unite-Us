<?php
/*
 * Custom functions
 *
 * @package Uniteus
 */

 /**
 * Convert an array of attributes into a string.
 *
 * @param array $attrs
 * @return string
 */

 if (!function_exists('html_attributes')) {
    function html_attributes(array $attrs): string {
        return collect($attrs)->map(function($value, $key) {
            if (is_bool($value)) {
                return $value ? $key : '';
            }
            return $key . '="' . e($value) . '"';
        })->filter()->implode(' ');
    }
 }
