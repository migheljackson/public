<?php
/**
 *
 *
 * @name fe_getevent
 * @description
 *
 */


// parameters from form
$core_path = $modx->getOption( 'col_public.core_path', '', MODX_CORE_PATH.'components/col_public/' );
if(!isset($_REQUEST["id"]) || empty($_REQUEST["id"])){
	header('Location: Error-Page?error=invalid program or event');
	die();
}

$workshop = $modx->runSnippet("getScheduledItem", array("scheduled_id" => $_REQUEST["id"]));

return;
