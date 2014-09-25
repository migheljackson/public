<?php
/**
 *
 *
 * @name fe_show_grant_access
 * @description takes all the parameters passed to it, and calls password_reset
 *
 */

$core_path = $modx->getOption( 'col_public.core_path', '', MODX_CORE_PATH.'components/col_public/' );
require_once $core_path.'col-library/col.php';
// load the org via token
$endpoint = '/orgs/retrieve_by_token.json';

if (!isset($_REQUEST["token"])) {
  return "The token parameter is missing";
}

if (!isset($_REQUEST["ouid"])) {
  return "The ouid parameter is missing ";
}


$payload = array('api_token' => $_REQUEST["token"], 'ouid' => $_REQUEST["ouid"]);


$org_response = COL::system_get_with_payload($endpoint, $payload );
//var_dump($org_response);
// if failure then show error message
if ($org_response->status != 200) {
  return "The token parameter does not match";
} else {

  $payload["org_name"] = $org_response->result->name;
  // check if the user is logged in
  if (COL::is_signed_in()) {
    // if logged in show the GrantAccessLoggedIn chunk
    $grantAccessLoggedInChunk = $modx->getOption( 'tpl', $scriptProperties, 'GrantAccessLoggedIn' );
    // craft access denied url with org call back
    $payload["org_access_denied_url"] = $org_response->result->access_callback_url."?error=access_denied";

    $page = $modx->getChunk( $grantAccessLoggedInChunk, $payload );
  } else {
    // show the GrantAccessNotLoggedIn chunk
    $grantAccessNotLoggedInChunk = $modx->getOption( 'tpl', $scriptProperties, 'GrantAccessNotLoggedIn' );

    // craft both urls for the sign up with redirect logic
    $create_account_url = "/sign-up?r=". urlencode("/auth?token".$_REQUEST["token"]."&ouid=".$_REQUEST["ouid"]);
    // craft login url with redirct logic
    $login_account_url = "/sign-in?r=". urlencode("/auth?token".$_REQUEST["token"]."&ouid=".$_REQUEST["ouid"]);
    
    $payload['login_account_url'] = $login_account_url;
    $payload['create_account_url'] = $create_account_url;
    
    $page = $modx->getChunk( $grantAccessNotLoggedInChunk, $payload );
  }
  return $page;
}