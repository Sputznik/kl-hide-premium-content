<?php
/*
Plugin Name: KL Hide Premium Content
Plugin URI: https://sputznik.com/
Description: Hide premium posts content based on posts category and subscription.
Version: 1.0.0
Author: Stephen Anil, Sputznik
Author URI: https://sputznik.com/
*/

if( ! defined( 'ABSPATH' ) ){ exit; }

define( 'KLHPC_VERSION', time() );
define( 'KLHPC_PATH', plugin_dir_path( __FILE__ ) );
define( 'KLHPC_URI', plugin_dir_url( __DIR__ ).'kl-hide-premium-content/' ); // ROOT URL
define( 'KLHPC_PARTIALS', KLHPC_PATH."partials/" );

$inc_files = array(
  'class-klhpc-base.php',
  'lib/lib.php',
  'admin/class-klhpc-admin.php'
);

foreach( $inc_files as $inc_file ){
	require_once( $inc_file );
}
