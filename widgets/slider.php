<?php 
require plugin_dir_path(__FILE__) . '../templates/frontend/slider.php';
class HC_HTML_slider_widget extends \Elementor\Widget_Base {

	public function get_name(): string {
		return 'hc_html_slider_widget';
	}

	public function get_title(): string {
		return __( 'HTML Slider' );
	}

	public function get_icon(): string {
		return 'eicon-code';
	}

	public function get_categories(): array {
		return [ 'basic' ];
	}

	public function get_keywords(): array {
		return [ 'slider', 'html', "hc" ];
	}

	protected function render(): void {
        new HC_HTML_slider_template(1, [1, 2, 3]);
	}

	protected function content_template(): void {
        new HC_HTML_slider_template(1, [1, 2, 3]);
	}
}