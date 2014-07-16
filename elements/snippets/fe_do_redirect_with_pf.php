<?php
/**
 *
 *
 * @name fe_do_redirect_with_pf
 * @description redirects to the direct sign up if there is a pf attribute (CHICAGO ONLY)
 *
 */
$core_path = $modx->getOption( 'col_public.core_path', '', MODX_CORE_PATH.'components/col_public/' );
require_once $core_path.'col-library/col.php';

if (isset($_REQUEST["pf"])) {
  $redirect_to = '/direct-signup?pf='.$_REQUEST["pf"];

  $modx->sendRedirect($redirect_to);
}