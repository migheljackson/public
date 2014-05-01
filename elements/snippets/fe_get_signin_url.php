<?php
/**
 *
 *
 * @name fe_get_signin_url
 * @description
 *
 */

$sign_base = $modx->config[’site_url’];

$require_secure = $modx->getOption('secure_login');

if ($require_secure == "No") {

} else {
  if (strpos($sign_base, "https") === 0) {

  } else {
    // replace http with https
    $sign_base = str_replace("http","https",$sign_base);
  }

  
}
return $sign_base."sign-in";