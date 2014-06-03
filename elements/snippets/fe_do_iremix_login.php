<?php
/**
 *
 *
 * @name fe_do_iremix_login
 * @description takes all the parameters passed to it, and calls password_reset
 *
 */
$core_path = $modx->getOption( 'col_public.core_path', '', MODX_CORE_PATH.'components/col_public/' );
require_once $core_path.'col-library/col.php';

$jwt_auth = COL::_get_jwt_token();

if (isset($jwt_auth) && count($jwt_auth) > 0) {
    
  $iframeChunk = $modx->getOption( 'tpl', $scriptProperties, 'IRemixAuthIframe');

  $iremixUrl = $modx->getOption('iremix_base_url');
  $iremixSubdomain = $modx->getOption('iremix_subdomain');

  $authUrl = $iremixUrl."/auth/jwt/callback?subdomain=".$iremixSubdomain."&jwt=".$jwt_auth;
  //var_dump($modx->getChunk( $iframeChunk, array('auth_url' => $authUrl)));
  return $modx->getChunk( $iframeChunk, array('auth_url' => $authUrl));
}

return "";