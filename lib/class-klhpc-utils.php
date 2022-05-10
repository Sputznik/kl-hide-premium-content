<?php

class KLHPC_UTILS extends KLHPC_BASE{

  public static function checkFilters(){
    return (  is_singular() && has_category( KLHPC_UTILS::getPremiumCategories() ) );
  }

  public static function getPremiumCategories(){
    global $kl_customize;
    $option = $kl_customize->get_option();
    $category_ids = !empty( $option['klhpc']['categories'] ) ?  explode(',', $option['klhpc']['categories']) : 'uncategorized';
    return $category_ids;
  }

  public static function getContentLength(){
    global $kl_customize;

    $option = $kl_customize->get_option();

    $length = 30;

    if ( isset( $option['klhpc']['content_length'] ) && $option['klhpc']['content_length'] ) {
      $length = intval($option['klhpc']['content_length']);
    }

    return $length;
  }

  public static function hasActiveSubscription(){
    if( !is_user_logged_in() ) return false;

    if( current_user_can( 'administrator' ) || current_user_can('editor') ) return true;

    $user_id = get_current_user_id();

    return wcs_user_has_subscription( $user_id, '', 'active' );
  }

  public static function deleteCookie( $cookie_name ){
    unset( $_COOKIE[$cookie_name] );
    setcookie( $cookie_name, null, -1, "/" );
  }

  // RETURNS UNIQUE ID
  public static function klhpcUniqueID( $data ){
    return substr( md5( json_encode( $data ) ), 0, 8 );
  }

  /**
   * CHECK IF IP IS VALID
   * @return bool Either TRUE or FALSE
   */
  public static function isValidIP(){
    $is_valid_ip = false;
    $client_ip = self::getClientIP();

    // ABORT VALIDATION IF CLIENT IP IS UNKNOWN
    if( $client_ip == "UNKNOWN" ) return $is_valid_ip;

    $ip_str = "10.129.0.0-10.129.255.255,128.112.0.0-128.112.255.255,140.180.0.0-140.180.255.255,192.55.106.0-192.55.106.255,192.103.13.0-192.103.13.255,192.188.106.0-192.188.106.255,198.35.0.0-198.35.15.255,198.125.224.0-198.125.239.255,5.198.138.135";

    $allowed_ip_range = explode(",", $ip_str);

    // LOOP THROUGH THE ALLOWED IP RANGE
    foreach ( $allowed_ip_range as $ip_range ) {
      $temp_range = explode( "-", $ip_range );
      $lower_limit = array_shift( $temp_range );
      $upper_limit = array_pop( $temp_range );

      // EXIT THE LOOP IF IP IS FOUND
      if( self::IsIpInRange( $lower_limit, $upper_limit, $client_ip ) ){
        $is_valid_ip = true;
        break;
      }
    }

    return $is_valid_ip;

  }

  /**
   * GET CLIENT IP ADDRESS
   * @return string
   */
	public static function getClientIP() {
		$ipaddress = '';
		if ( isset( $_SERVER['HTTP_CLIENT_IP'] ) )
			$ipaddress = $_SERVER['HTTP_CLIENT_IP'];
		else if( isset( $_SERVER['HTTP_X_FORWARDED_FOR'] ) )
			$ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
		else if( isset( $_SERVER['HTTP_X_FORWARDED'] ) )
			$ipaddress = $_SERVER['HTTP_X_FORWARDED'];
		else if( isset( $_SERVER['HTTP_FORWARDED_FOR'] ) )
			$ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
		else if( isset( $_SERVER['HTTP_FORWARDED'] ) )
			$ipaddress = $_SERVER['HTTP_FORWARDED'];
		else if( isset( $_SERVER['REMOTE_ADDR'] ) )
			$ipaddress = $_SERVER['REMOTE_ADDR'];
		else
			$ipaddress = 'UNKNOWN';
		return $ipaddress;
	}

  /**
   * CHECK THE CLIENT IP AGAINST A LIST OF ALLOWED IP RANGE FROM THEME OPTION
   * @return bool Either TRUE or FALSE
   */
  public static function IsIpInRange( $ip_lower_limit, $ip_upper_limit, $current_ip ){

   // GET THE NUMERIC REPRESENTATION OF THE IP ADDRESS WITH IP2long
   $needle = ip2long( $current_ip );
   $min    = ip2long( $ip_lower_limit );
   $max    = ip2long( $ip_upper_limit );

   if( !$max ) { return ( $needle ==  $min ); } // CHECK FOR THE EXACT IP IF UPPER LIMIT IS NOT SET

   // CHECK WHETHER THE NEEDLE FALLS BETWEEN THE LOWER AND UPPER LIMIT
   return ( ( $needle >= $min ) && ( $needle <= $max ) );
  }

}
