<?php
/**
 *
 *
 * @name fe_do_delete_account
 * @description takes all the parameters passed to it, and calls the account_vetos/confirm in the engine
 *
 */

$core_path = $modx->getOption( 'col_public.core_path', '', MODX_CORE_PATH.'components/col_public/' );
require_once $core_path.'col-library/col.php';
$params = array('user' => array('veto_token' => $_REQUEST["veto_token"] , 'username' =>  $_REQUEST["username"]));

// compress all reasons
$all_reasons = '';
if(isset($_REQUEST["reasons"])) {
  $all_reasons = implode("\r\n", $_REQUEST["reasons"]);
}

$params['account_veto'] = array('reason' => $all_reasons, 'origin' => $_REQUEST["origin"]);

return COL::post_json('/account_vetos/confirm.json', $params);