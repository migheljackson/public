<?php
/**
 *
 *
 * @name fe_do_claim_codes
 * @description takes claim codes and tries to submit them
 */

$core_path = $modx->getOption( 'col_public.core_path', '', MODX_CORE_PATH.'components/col_public/' );
require_once $core_path.'col-library/col.php';
require_once $core_path.'col-library/col_user.php';

if (COL::is_signed_in()) {
  $params = array('token' => COL::_get_token(), 'user' => array('claim_codes' => $_REQUEST["claim_codes"] ) );
  $response = COL::post_json('/users/claim_codes.json', $params);
  return $response;
} 

header('Location: sign-in');
die();