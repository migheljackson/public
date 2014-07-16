<?php
/**
 *
 *
 * @name fe_do_get_sign_up_prefill
 * @description takes all the parameters passed to it, and calls password_reset
 *
 */
$core_path = $modx->getOption( 'col_public.core_path', '', MODX_CORE_PATH.'components/col_public/' );
require_once $core_path.'col-library/col.php';

if (isset($_REQUEST["pf"])) {
  $response = COL::system_get_encrypted_with_payload('/users/request_user_details.json', array('pf' => $_REQUEST["pf"]));

  if ($response->status == 200) {
    $modx->setPlaceholders($response->result);
  }
}