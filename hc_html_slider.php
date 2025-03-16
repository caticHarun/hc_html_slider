<?php
/*
Plugin Name: HC HTML Slider
Description: Adding an HTML Slider
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
if (!class_exists('HC_html_slider_plugin')) {
    require plugin_dir_path(__FILE__) . '/templates/frontend/slider.php';
    class HC_html_slider_plugin
    {
        // Data
        public $version = 0.1; //HC_UPDATE to 1

        // Tailwind //HC_REMOVE
        public function loadTailwind()
        {
            wp_enqueue_script(
                "Tailwind CSS",
                "https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4",
                [],
                $this->version,
                []
            );
        }

        // Widgets
        public function firstSlider() {
            ob_start();
            new HC_HTML_slider_template(1, ["h", "a", "r"]);
            return ob_get_clean();
        }

        //Construct
        public function __construct()
        {
            //Tailwind
            add_action("wp_enqueue_scripts", [$this, "loadTailwind"]);

            //Widgets
            add_shortcode('firstSlider', [$this, "firstSlider"]);
        }
    }

    new HC_html_slider_plugin();
}