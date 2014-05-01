<?php
/**
 *
 *
 * @name fe_do_setavatar
 * @description
 *
 */

// parameters from form
$core_path = $modx->getOption( 'col_public.core_path', '', MODX_CORE_PATH.'components/col_public/' );
require_once $core_path.'col-library/col.php';
require_once $core_path.'col-library/col_user.php';

$response = COL_User::set_avatar($_REQUEST["preset_avatar_id"]);


return $response;