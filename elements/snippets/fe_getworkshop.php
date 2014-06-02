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

$workshop = $modx->runSnippet("getScheduledItem", array("scheduled_id" => $_REQUEST["id"]));

$relatedItemCountMax = 5;
$relatedTpl = $modx->getOption( 'tpl', $scriptProperties, 'WorkshopRelatedWorkshops' );
$relatedItemTpl = $modx->getOption( 'tpl', $scriptProperties, 'WorkshopRelatedItem' );

$lat = $modx->getPlaceholder("latitude");
$long = $modx->getPlaceholder("longitude");

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

$relatedItemCountMax = 5;
$categoriesHtml = "";
// get related workshops by category
foreach ( $workshop['categories'] as $category ) {

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
$modx->setPlaceholder( 'relatedCategoryHtml', $categoriesHtml );

return;
