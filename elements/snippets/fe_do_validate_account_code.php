<?php
/**
 *
 *
 * @name fe_do_validate_account_code
 * @description
 *
 */

// parameters from form
$core_path = $modx->getOption( 'col_public.core_path', '', MODX_CORE_PATH.'components/col_public/' );
require_once $core_path.'col-library/col.php';
require_once $core_path.'col-library/col_user.php';


$response = COL_User::validate_claim_code($_REQUEST["dob"], $_REQUEST["name"], $_REQUEST["code"]);

return $response;