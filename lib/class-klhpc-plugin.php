<?php

class KLHPC_PLUGIN extends KLHPC_BASE{

  function __construct(){

   /* LOAD PLUGIN ASSETS */
   add_action( 'wp_enqueue_scripts', array( $this, 'assets') );

   add_filter( 'the_content', array( $this, 'limitContentCharacters' ), 15 );

  }

  function limitContentCharacters( $content ){
    if( ( ! is_user_logged_in() ) && KLHPC_UTILS::checkFilters() ){
      // SHOW PREMIUM CONTENT IF THE CLIENT IP IS FOUND TO BE IN THE ALLOWED IP RANGE
      if( ! KLHPC_UTILS::isValidIP() ){
        return $this->getTruncatedContent( $content, 'klhpc-logged-out-sidebar' );
      }
      else{
        return $content;
      }
    }
    elseif( is_user_logged_in() && KLHPC_UTILS::checkFilters() && ! KLHPC_UTILS::hasActiveSubscription() ) {
      return $this->getTruncatedContent( $content, 'klhpc-logged-in-sidebar' );
    }
    else {
      return $content;
    }
  }

  function getTruncatedContent( $content, $sidebar ){

    global $kl_customize;

    $option = $kl_customize->get_option();

    $trimmed_content = wp_trim_words( $content, KLHPC_UTILS::getContentLength(), $this->getTemplate( $sidebar ) );

    return $trimmed_content;
  }

  function getSidebar( $sidebar_id ){

  	if( is_active_sidebar( $sidebar_id ) && $sidebar_id ){
  		dynamic_sidebar( $sidebar_id );
  	}

  }


  function getTemplate( $sidebar ){
    ob_start();
    include( KLHPC_PARTIALS."/klhpc-sidebar.php");
    return ob_get_clean();
  }

  function assets(){
    // STYLES
    wp_enqueue_style('klhpcp-css', KLHPC_URI.'assets/css/main.css', array(), time() );

    // SCRIPTS
    wp_enqueue_script( 'klhpcp-redirect-cookie', KLHPC_URI.'assets/js/main.js', array('jquery'), time(), true );

  }

}

KLHPC_PLUGIN::getInstance();
