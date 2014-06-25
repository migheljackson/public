<?php
/**
 *
 *
 * @name fe_getworkshop
 * @description
 *
 */


// parameters from form
$core_path = $modx->getOption( 'col_public.core_path', '', MODX_CORE_PATH.'components/col_public/' );
require_once $core_path.'col-library/col.php';
require_once $core_path.'col-library/col_scheduled_program.php';

$scheduled_program_id = $_REQUEST['id'];

$searchResults = COL_Scheduled_Program::getScheduledProgram( $scheduled_program_id );

COL::log_action('read', array('object_id' => $scheduled_program_id , 'object_type' => 'ScheduledProgram'));

$workshop = $searchResults["_source"];
// extract results and build the page elements

// fix date and time formats
if ( $workshop['start_date']!=null ) {
	$startDateTime = new DateTime( $workshop['start_date'] );
	$workshop['start_date'] = $startDateTime->format( "m/d/Y" );
}

if ( $workshop['end_date']!=null ) {
	$endDateTime = new DateTime( $workshop['end_date'] );
	$workshop['end_date'] = $endDateTime->format( "m/d/Y" );
}

$workshop = $modx->runSnippet("getScheduledItem", array("scheduled_id" => $_REQUEST["id"]));
return;
