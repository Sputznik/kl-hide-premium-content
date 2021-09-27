jQuery(document).ready(function(){

  var $cookie_btn = jQuery("[data-behaviour~=klhpc_redirect_url_cookie]");

  if( $cookie_btn.length ){
    $cookie_btn.on('click',function(e){
      setRedirectCookie();
    });
  }

  function setRedirectCookie( name = 'klhpc_redirect_url_cookie', minutes = 30 ){
    var date            = new Date();
    var currentPageURL  = window.location.href;

    // console.log(date);
    date.setTime( date.getTime() + ( minutes * 60 * 1000 ) );
    // console.log(date);

    document.cookie = name + '='+ currentPageURL +'; expires=' + date.toGMTString() + '; path=/';
  }

});
