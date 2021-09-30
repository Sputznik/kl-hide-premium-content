<?php

class KLHPC_ADMIN extends KLHPC_BASE{

	var $cookie_name;

	function __construct(){

		$this->cookie_name = 'klhpc_redirect_url_cookie';

		// WP SIDEBAR WIDGETS
		add_action( 'widgets_init', array( $this, "klhpcWidgets" ) );

		/* REDIRECT USERS ON LOGIN BASED ON PREMIUM CONTENT */
		add_filter( 'login_redirect', function( $url, $request, $user ){
	    if( $user && is_object( $user ) && is_a( $user, 'WP_User' ) ){

				if( isset(	$_COOKIE[$this->cookie_name] ) ){
					$url = $_COOKIE[$this->cookie_name];

					// DELETE COOKIE ON LOGIN
					KLHPC_UTILS::deleteCookie( $this->cookie_name );
				}

			}

	    return $url;
		}, 10, 3 );


		/* ADD SOW FROM THE PLUGIN */
    add_action('siteorigin_widgets_widget_folders', function( $folders ){
      $folders[] = KLHPC_PATH.'/so-widgets/';
      return $folders;
    });

		// CUSTOMIZER OPTIONS
		add_action( 'customize_register', array( $this, 'klhpcCustomizer' )	);

		// MODIFY WOOCOMMERCE THANK YOU PAGE
		add_action( 'woocommerce_thankyou', array( $this, 'modifyThankyou' ), 10, 1 );

	}

	function klhpcWidgets(){

		register_sidebar( array(
			'name' 			    => 'Logged in Sidebar',
			'description'   => 'Appears in the premium posts page when the user is logged in and has no active subscription',
			'id' 			      => 'klhpc-logged-in-sidebar',
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget' 	=> '</aside>',
			'before_title' 	=> '<h3 class="widget-title">',
			'after_title' 	=> '</h3>',
		) );

		register_sidebar( array(
			'name' 			    => 'Logged out Sidebar',
			'description'   => 'Appears in the premium posts page when the user is logged out',
			'id' 			      => 'klhpc-logged-out-sidebar',
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget' 	=> '</aside>',
			'before_title' 	=> '<h3 class="widget-title">',
			'after_title' 	=> '</h3>',
		) );

	}

	function klhpcCustomizer( $wp_customize ){

		if( class_exists( 'KL_THEME_CUSTOMIZE' ) ){

			global $kl_customize;

			$kl_customize->section( $wp_customize, 'kl_theme_panel', 'klhpc_premium_content', 'Premium Content', 'Premium Content Settings', 40 );

			$kl_customize->text( $wp_customize, 'klhpc_premium_content', '[klhpc][content_length]', "Post Content Length (Default 30 words)", '30' );

			$kl_customize->text( $wp_customize, 'klhpc_premium_content', '[klhpc][categories]', "Comma separated category slug", '');

		}

	}

	function modifyThankyou( $order_id ) {
		if( isset(	$_COOKIE[$this->cookie_name] ) ){

			$premium_post = "<p>
				<a href='".$_COOKIE[$this->cookie_name]."' data-behaviour='klhpc_delete_redirect_url_cookie'>"
				.__('Back to the premium post').
				"</a></p>";

			echo $premium_post;

		}
	}

}

KLHPC_ADMIN::getInstance();
