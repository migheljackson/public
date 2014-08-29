<?php
/**
 *
 *
 * @name fe_do_unsubscribe_email
 * @description takes all the parameters passed to it, and calls the account_vetos/confirm in the engine
 *
 */

$core_path = $modx->getOption( 'col_public.core_path', '', MODX_CORE_PATH.'components/col_public/' );
require_once $core_path.'col-library/col.php';
$params = array('email_address' => $_REQUEST["email"] );

// compress all reasons
$all_reasons = '';
if(isset($_REQUEST["reasons"])) {
  $all_reasons = implode("\r\n", $_REQUEST["reasons"]);
}

$params['reason'] = $all_reasons;
COL::log_action('unsubscribe_email_address', array());
return COL::post_encrypted_json('/unsubscribed_emails.json', $params);