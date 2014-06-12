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

// pull up from getworkshop nearbyHTML
$relatedItemCountMax = 5;
$relatedTpl = $modx->getOption( 'tpl', $scriptProperties, 'WorkshopRelatedWorkshops' );
$relatedItemTpl = $modx->getOption( 'tpl', $scriptProperties, 'WorkshopRelatedItem' );

$lat = $workshop["latitude"];
$long = $workshop["longitude"];

if ($lat!=null && $long!=null) {
	$searchResults = COL::search( "", null, null, null, null, null, 0, $relatedItemCountMax+1, $lat, $long, "3km" );

	if ( $searchResults['hits']['total'] >  0 ) {

		$items = "";
		$count = 0;
		foreach ( $searchResults['hits']['hits'] as $hit ) {

			if ( $count ==  $relatedItemCountMax ) {
				break;
			}
			$sp = $hit['_source'];

			if ( !isset( $sp['logo_url'] ) || strlen( $sp['logo_url'] )==0 ) {
				$logo_url = 'http://cityoflearning-uploads.s3.amazonaws.com/default_logos/';
				if ( $sp['program_type']=='workshop' ) {
					$logo_url .= 'ws_';
				} else {
					$logo_url .= 'ev_';
				}
				if ( $sp["meeting_type"]=='online' ) {
					$logo_url .= 'on.png';
				} else {
					$logo_url .= 'f2f.png';
				}
				$sp['logo_url'] = $logo_url;
			}

			if ( $sp["id"] != $modx->getPlaceholder("id") ) {
				$items .= $modx->getChunk( $relatedItemTpl, $sp );
				$count += 1;
			}
		}

		$nearbyWorkshops = $modx->getChunk( $relatedTpl, array( 'title' => "nearby",  'related_workshop_items' => $items ) );
		$modx->setPlaceholder( 'nearbyHtml', $nearbyWorkshops );
	}
}

// end refactoring nearbyHTML

$categoryText = "";
$relatedItemCountMax = 5;
$categoriesHtml = "";
// get related workshops by category
$relatedTpl = $modx->getOption( 'tpl', $scriptProperties, 'WorkshopRelatedWorkshops' );
$relatedItemTpl = $modx->getOption( 'tpl', $scriptProperties, 'WorkshopRelatedItem' );

foreach ($workshop['categories'] as $category ) {
	$categoryText .= "<li>" . $category["name"] . "</li>";
	$searchResults = COL::search( "", array( $category["id"] ), null, null, null, null, 0, $relatedItemCountMax+1, $workshop["latitude"], $workshop["longitude"], "30km" );

	if ( $searchResults['hits']['total'] >  0 ) {

		$items = "";
		$count = 0;
		foreach ( $searchResults['hits']['hits'] as $hit ) {

			if ( $count == $relatedItemCountMax ) {
				break;
			}
			$sp = $hit['_source'];

			if ( !isset( $sp['logo_url'] ) || strlen( $sp['logo_url'] )==0 ) {
				$logo_url = 'http://cityoflearning-uploads.s3.amazonaws.com/default_logos/';
				if ( $sp['program_type']=='workshop' ) {
					$logo_url .= 'ws_';
				} else {
					$logo_url .= 'ev_';
				}
				if ( $sp["meeting_type"]=='online' ) {
					$logo_url .= 'on.png';
				} else {
					$logo_url .= 'f2f.png';
				}
				$sp['logo_url'] = $logo_url;
			}
			

			if ( $sp["id"] != $workshop["id"] ) {
				$items .= $modx->getChunk( $relatedItemTpl, $sp );
				$count += 1;
			}

		}
		$categoriesHtml .= $modx->getChunk( $relatedTpl, array( 'title' => "More in ".$category["name"]." Category",  'related_workshop_items' => $items ) );
	}
}
$modx->setPlaceholder('relatedCategoryHtml', $categoriesHtml);

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
$badgeChunk = $modx->getOption('tpl', $scriptProperties, 'ScheduledProgramBadgeItem');
if($workshop['badges']!=null) {
	$badgeHtml = "<h6>You can earn these badges</h6><div class='row' style='margin-bottom:12px'>";
	foreach ($workshop['badges'] as $badge) {
		$badgeHtml .= $modx->getChunk($badgeChunk, $badge);
	}
	$badgeHtml .="</div>";
	$workshop['badgesHtml'] = $badgeHtml;
}

$modx->setPlaceholders($workshop);
return $workshop;