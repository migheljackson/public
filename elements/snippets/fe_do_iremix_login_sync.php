<?php
/**
 *
 *
 * @name fe_do_iremix_login_sync
 * @description takes all the parameters passed to it, and calls password_reset
 *
 */
$core_path = $modx->getOption( 'col_public.core_path', '', MODX_CORE_PATH.'components/col_public/' );
require_once $core_path.'col-library/col.php';

$user_token = COL::_get_token();

if(count($user_token)>0) {
  return $modx->runSnippet('fe_do_iremix_login');
} else {
  return $modx->runSnippet('fe_do_iremix_signout');
}