<?php
/**
 *
 *
 * @name fe_do_update_account
 * @description takes all the parameters passed to it, and calls the account_vetos/confirm in the engine
 *
 */

$core_path = $modx->getOption( 'col_public.core_path', '', MODX_CORE_PATH.'components/col_public/' );
require_once $core_path.'col-library/col.php';
require_once $core_path.'col-library/col_user.php';

$response = COL_User::update_account( $_REQUEST["id"], $_REQUEST["username"], $_REQUEST["full_name"],
    $_REQUEST["dob"],$_REQUEST["password"],$_REQUEST["email_address"], $_REQUEST["guardian_email_address"], 
    $_REQUEST["guardian_name"], $_REQUEST["guardian_phone"]
  );

return JWT::jsonEncode($response);