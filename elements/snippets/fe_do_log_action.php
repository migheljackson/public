<?php
/**
 *
 *
 * @name fe_do_log_action
 * @description takes username or email from forgotten password page, and either returns email message or form to do password reset
 *
 */

$core_path = $modx->getOption( 'col_public.core_path', '', MODX_CORE_PATH.'components/col_public/' );
require_once $core_path.'col-library/col.php';

$param_data_keys = array('artifact_id', 'artifact_type', "extra_params", "artifact_title");

$log_parameters = array();

foreach ($param_data_keys as $key) {
  $log_parameters[$key] = $_REQUEST[$key];
}

COL::log_action($_REQUEST["action"], $log_parameters );