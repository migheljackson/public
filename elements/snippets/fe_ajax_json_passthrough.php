<?php
/**
 *
 *
 * @name fe_ajax_json_passthrough
 * @description
 *
 */
$core_path = $modx->getOption( 'col_public.core_path', '', MODX_CORE_PATH.'components/col_public/' );
require_once $core_path.'col-library/col.php';

// load orgs
if(isset($_REQUEST["method"]) && $_REQUEST["method"] == "post" ) {
  $response = COL::post_json_logged_in($_REQUEST["endpoint"], $_REQUEST["payload"]);
} else {
  $response = COL::get_json_with_payload($_REQUEST["endpoint"], $_REQUEST["payload"]);
}


if (isset($_REQUEST["encoded"])) {
  $response = JWT::decode($response, COL::KEY);
}


return $response;