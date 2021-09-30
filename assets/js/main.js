jQuery(document).ready(function(){

  // COOKIE UTILS
  var kl_redirect_cookie_utils = {
    cookieBtnExists: function( btn ){
      return btn.length;
    },
    setRedirectCookie: function( name = 'klhpc_redirect_url_cookie', minutes = 30 ){
      var date            = new Date();
      var currentPageURL  = window.location.href;
      date.setTime( date.getTime() + ( minutes * 60 * 1000 ) );
      document.cookie = name + '='+ currentPageURL +'; expires=' + date.toGMTString() + '; path=/';
    },
    deleteRedirectCookie: function( name = 'klhpc_redirect_url_cookie' ){
      document.cookie = name + '=; expires=Thu, 01 Jan 1970 00:00:00 GMT; path=/';
    }
  };

  // COOKIE BUTTONS ARRAY
  var kl_cookie_btns = [
    {
      behaviour    : 'klhpc_redirect_url_cookie',
      btnCallback  : kl_redirect_cookie_utils.setRedirectCookie
    },
    {
      behaviour    : 'klhpc_delete_redirect_url_cookie',
      btnCallback  : kl_redirect_cookie_utils.deleteRedirectCookie
    }
  ];


  // LOOP THROUGH THE COOKIE BUTTONS
  kl_cookie_btns.forEach( function( btn ){
    var $cookie_btn = jQuery("[data-behaviour~="+ btn.behaviour +"]");
    // CHECK IF THE BUTTON EXISTS
    if( kl_redirect_cookie_utils.cookieBtnExists( $cookie_btn ) ){
      $cookie_btn.on('click',function(e){
        // e.preventDefault();
        btn.btnCallback(); // SET CALLBACK
      });
    }
  });

});
