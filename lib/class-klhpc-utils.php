<?php

class KLHPC_UTILS extends KLHPC_BASE
{

  public static function checkFilters()
  {
    return (is_singular() && has_category(KLHPC_UTILS::getPremiumCategories()));
  }

  public static function getPremiumCategories()
  {
    global $kl_customize;
    $option = $kl_customize->get_option();
    $category_ids = !empty($option['klhpc']['categories']) ?  explode(',', $option['klhpc']['categories']) : 'uncategorized';
    return $category_ids;
  }

  public static function getContentLength()
  {
    global $kl_customize;

    $option = $kl_customize->get_option();

    $length = 30;

    if (isset($option['klhpc']['content_length']) && $option['klhpc']['content_length']) {
      $length = intval($option['klhpc']['content_length']);
    }

    return $length;
  }

  public static function hasActiveSubscription()
  {
    if (!is_user_logged_in()) return false;

    $user_id = get_current_user_id();
    return wcs_user_has_subscription($user_id, '', 'active');
  }

  public static function deleteCookie($cookie_name)
  {
    unset($_COOKIE[$cookie_name]);
    setcookie($cookie_name, null, -1, "/");
  }
}
