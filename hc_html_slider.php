<?php
/*
Plugin Name: HC HTML Slider for Elementor
Description: Adding an HTML Slider in Elementor
Version: 1.0.0
Author: catic.harun@gmail.com
*/

// Activation
register_activation_hook(__FILE__, 'hc_html_slider_activate');
function hc_html_slider_activate()
{
}

// Deactivation
register_deactivation_hook(__FILE__, 'hc_html_slider_deactivate');
function hc_html_slider_deactivate()
{
}

// Uninstall
register_uninstall_hook(__FILE__, 'hc_html_slider_uninstall');
function hc_html_slider_uninstall()
{
}

//Programming logic
if (!class_exists('hc_html_slider_plugin')) {
    class hc_html_slider_plugin
    {

        //Construct
        private function __construct()
        {
        }
    }

    new hc_html_slider_plugin();
}