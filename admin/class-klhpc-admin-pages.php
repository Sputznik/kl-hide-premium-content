<?php

class KLHPC_ADMIN_PAGES extends KLHPC_BASE {

  var $settings;

  function __construct(){

    $this->read_settings();

    add_action( 'admin_menu', function(){
			add_menu_page( 'KL Settings', 'KL Settings', 'manage_options', 'klhpc', array( $this, 'menu_page' ) );
		} );

    /* ENQUEUE SCRIPTS ON ADMIN DASHBOARD */
    add_action( 'admin_enqueue_scripts', array( $this, 'wp_admin_script') );

  }

	function wp_admin_script( $hook ) {
		if( $hook == 'toplevel_page_klhpc' ) {
			wp_enqueue_script( 'klhpc-repeater', KLHPC_URI.'/assets/js/klhpc-repeater.js', array( 'jquery', 'orbit-repeater' ), time(), true );
		}
	}

	function menu_page() {
		include( "settings/klhpc-admin-settings.php" );
	}

  function get_settings(){ return $this->settings; }
  function set_settings( $settings ){ $this->settings = $settings; }

  function read_settings(){
    $value = get_option( 'kl_theme' );
    if( !$value || !is_array( $value ) ) return array();
    $this->set_settings( $value );
  }

  function write_settings( $settings ){
    update_option( 'kl_theme', $settings );
    $this->set_settings( $settings );
  }

  function show_update_notice( $message ){
		?>
		<div class="updated notice">
    	<p><strong><?php _e( $message );?></strong></p>
		</div>
		<?php
	}

}

KLHPC_ADMIN_PAGES::getInstance();
