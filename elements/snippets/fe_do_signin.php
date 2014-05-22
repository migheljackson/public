<?php
/**
 *
 *
 * @name fe_do_signin
 * @description takes form from signup and returns json results
 *
 */

$core_path = $modx->getOption( 'col_public.core_path', '', MODX_CORE_PATH.'components/col_public/' );
require_once $core_path.'col-library/col.php';
require_once $core_path.'col-library/col_user.php';

$response = COL_User::signin($_REQUEST["username"], $_REQUEST["password"]);
COL::log_action('signin', array());
return $response;