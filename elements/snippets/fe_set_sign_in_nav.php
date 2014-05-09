<?php
/**
 *
 *
 * @name fe_set_sign_in_nav
 * @description
 *
 */

// check cookie to see if the user is signed in

$core_path = $modx->getOption( 'col_public.core_path', '', MODX_CORE_PATH.'components/col_public/' );
require_once $core_path.'col-library/col.php';

if ( COL::is_signed_in() ) {
  if ( isset( $small ) ) {
    $sChunk = $modx->getOption( 'tpl', $scriptProperties, 'SignedInNavBarSmall' );
  }
  else {
    $sChunk = $modx->getOption( 'tpl', $scriptProperties, 'SignedInNavBar' );
  }
  
  $params = array( 'user_avatar_image_url' => COL::_get_avatar_image(), 'user_username' => COL::_get_name() ) ;

  return $modx->getChunk( $sChunk, $params);

} else {
  if ( isset( $small ) ) {
    $sChunk = $modx->getOption( 'tpl', $scriptProperties, 'SignInSmallNavBar' );
  } else {
    $sChunk = $modx->getOption( 'tpl', $scriptProperties, 'SignInLargeNavBar' );
  }
  return $modx->getChunk( $sChunk );
}