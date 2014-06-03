<?php
/**
 *
 *
 * @name fe_do_signout
 * @description takes form from signup and returns json results
 *
 */

$core_path = $modx->getOption( 'col_public.core_path', '', MODX_CORE_PATH.'components/col_public/' );
require_once $core_path.'col-library/col.php';
require_once $core_path.'col-library/col_user.php';

COL::log_action('signout', array());
$response = COL_User::signout();


$redirect_to = '/sign-in';

$modx->sendRedirect($redirect_to);