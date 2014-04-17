<?php

/**
 *
 *
 * @name getScheduledItem
 * @description
 *
 */

// parameters from form
$core_path = $modx->getOption( 'col_public.core_path', '', MODX_CORE_PATH.'components/col_public/' );
require_once $core_path.'col-library/col.php';
require_once $core_path.'col-library/col_scheduled_program.php';


if(!isset($scheduled_id)) {
	return array();
} else {
	$scheduled_program_id = $_REQUEST['id'];
}

$searchResults = COL_Scheduled_Program::getScheduledProgram( $scheduled_program_id );

$workshop = $searchResults["_source"];
// print_r($workshop);
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

if ( $workshop['start_time']!=null ) {
	$startDateTime = new DateTime( $workshop['start_time'] );
	$workshop['start_time'] = $startDateTime->format( "g:i A" );
} else {
	$workshop['start_time'] = "See Schedule";
}

if ( $workshop['end_time']!=null ) {
	$endDateTime = new DateTime( $workshop['end_time'] );
	$workshop['end_time'] = $endDateTime->format( "g:i A" );
} else {
	$workshop['end_time'] = "See Schedule";
}

$workshop['price'] = $workshop['price']==0 ? "FREE" : "$";
$categoryText = "";
// todo: transfer to chunk
foreach ( $workshop['categories'] as $category ) {
	$categoryText .= "<li>" . $category["name"] . "</li>";
}

$workshop["categoryHtml"] = $categoryText;

// weekday logic

$weekdayList = "";

if($workshop["scheduled_sun"]) {
	$weekdayList .= "Sun, ";
}
if($workshop["scheduled_mon"]) {
	$weekdayList .= "Mon, ";
}
if($workshop["scheduled_tues"]) {
	$weekdayList .= "Tue, ";
}
if($workshop["scheduled_wed"]) {
	$weekdayList .= "Wed, ";
}
if($workshop["scheduled_thurs"]) {
	$weekdayList .= "Thu, ";
}
if($workshop["scheduled_fri"]) {
	$weekdayList .= "Fri, ";
}
if($workshop["scheduled_sat"]) {
	$weekdayList .= "Sat, ";
}

if($weekdayList!="") {
	$weekdayList = rtrim($weekdayList, ", ");
	$workshop["weekdays"] = "Days: " . $weekdayList;
}

$contactChunk = $modx->getOption( 'tpl', $scriptProperties, 'scheduledItemContactItem' );
// $nearbyWorkshops = $modx->getChunk( $relatedTpl, array( 'title' => "nearby",  'related_workshop_items' => $items ) );

// contact chunk
if ( $workshop['contact_name']!=null || $workshop['contact_email']!=null || $workshop['contact_phone']!=null || $workshop['program_url']!=null ) {
	$workshopContact = '<li><h4 class="event-block-title center">workshop contact</h4><div class="event-block clearfix">';
	// add name if it exists
	if ( $workshop['contact_name'] ) {
		$workshopContact .= $modx->getChunk($contactChunk, array( 'contact_info' => $workshop['contact_name'],  'contact_type' => "ct_name"));
	}

	if ( $workshop['contact_email'] ) {
		$workshopContact .= $modx->getChunk($contactChunk, array( 'contact_info' => $workshop['contact_email'],  'contact_type' => "ct_email"));
	}

	if ( $workshop['contact_phone'] ) {
		$workshopContact .= $modx->getChunk($contactChunk, array( 'contact_info' => $workshop['contact_phone'],  'contact_type' => "ct_phone"));
	}

	if ( $workshop['program_url'] ) {
		$workshopContact .= $modx->getChunk($contactChunk, array( 'contact_info' => $workshop['contact_url'],  'contact_type' => "ct_url"));
	}

	$workshop["contactHtml"] = $workshopContact;
}

if ( $workshop['registration_deadline']!=null ) {
	$endDateTime = new DateTime( $workshop['registration_deadline'] );
	$workshop['registration_deadline'] = $endDateTime->format( "m/d/Y" );
} else {
	$workshop['registration_deadline'] = "n/a";
}

// display button for reg url
if ( $workshop['registration_url']!=null ) {
	$url_to_use = $workshop['registration_url'];
	if ( strpos( $url_to_use, "http" )===0 ) {
	} else {
		$url_to_use = "http://".$url_to_use;
	}
	$workshop['reg_button'] = "<a class='small button radius' href='".$url_to_use."'>Register</a>";
}

if ( $workshop['program_url']!=null ) {
	$url_to_use = $workshop['program_url'];
	if ( strpos( $url_to_use, "http" )===0 ) {
	} else {
		$url_to_use = "http://".$url_to_use;
	}
	$workshop['prog_button'] = "<a class='small button radius' href='".$url_to_use."'>Learn more</a>";
}

$modx->setPlaceholders($workshop);
return $workshop;