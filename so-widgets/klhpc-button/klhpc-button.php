<?php
/*
	Widget Name: KLHPC Button Widget
	Description: Button that redirects to custom url and sets redirect url cookie.
	Author: Stephen Anil, Sputznik
	Author URI:	https://sputznik.com
	Widget URI:
	Video URI:
*/
class KLHPC_Button_Widget extends SiteOrigin_Widget {

	function __construct() {
		//Here you can do any preparation required before calling the parent constructor, such as including additional files or initializing variables.
		//Call the parent constructor with the required arguments.
		parent::__construct(
			// The unique id for your widget.
			'klhpc-button',
			// The name of the widget for display purposes.
			__('KLHPC Button Widget', 'siteorigin-widgets'),
			// The $widget_options array, which is passed through to WP_Widget.
			// It has a couple of extras like the optional help URL, which should link to your sites help or support page.
			array(
				'description' => __('Button that redirects to custom url and sets redirect url cookie.'),
				'help'        => '',
			),
			//The $control_options array, which is passed through to WP_Widget
			array(),
			//The $form_options array, which describes the form fields used to configure SiteOrigin widgets. We'll explain these in more detail later.
			array(
				'btn_text' => array(
          'type'    => 'text',
          'label'   => __('Button Text','siteorigin-widgets'),
          'default' => '',
        ),
				'btn_url' => array(
          'type'    => 'text',
          'label'   => __('Redirect URL','siteorigin-widgets'),
          'default' => '',
        ),
				'btn_text_color' => array(
          'type' => 'color',
          'label' => __( 'Button Text Colour', 'siteorigin-widgets' ),
          'default' => '#e6e6e6'
        ),
        'btn_bg_color' => array(
          'type' => 'color',
          'label' => __( 'Button Background Colour', 'siteorigin-widgets' ),
          'default' => '#1a8917'
        ),

			),
			//The $base_folder path string.
			get_template_directory()."/so-widgets/klhpc-button"
		);
	}

	function get_template_name($instance) {
		return 'template';
	}
	function get_template_dir($instance) {
		return 'templates';
	}
  function get_style_name($instance) {
      return '';
  }
}
siteorigin_widget_register('klhpc-button', __FILE__, 'KLHPC_Button_Widget');
