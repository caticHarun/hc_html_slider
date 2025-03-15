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
    if (!did_action('elementor/loaded')) { //If no elementor
        deactivate_plugins(plugin_basename(__FILE__));
        wp_die('<p><strong>My Custom Plugin</strong> requires <a href="https://wordpress.org/plugins/elementor/" target="_blank">Elementor</a> to be installed and activated.</p> <p><a href="' . admin_url('plugins.php') . '">&larr; Go back to Plugins</a></p>');
    }
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
    class HC_html_slider_plugin
    {
        // Data
        public $version = 0.1; //HC_UPDATE to 1

        // Tailwind //HC_REMOVE
        public function loadTailwind() {
            wp_enqueue_script(
                "Tailwind CSS",
                "https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4",
                [],
                $this->version,
                []
            );
        }

        // Widgets
        public function register_widgets( $widgets_manager ) {
            require_once( __DIR__ . '/widgets/slider.php' );
            $widgets_manager->register( new \HC_HTML_slider_widget() );
        }

        //Construct
        public function __construct()
        {
            //Tailwind
            add_action("wp_enqueue_scripts", [$this, "loadTailwind"]);

            //Widgets
            add_action( 'elementor/widgets/register', [$this, "register_widgets"] );
        }
    }

    new HC_html_slider_plugin();
}