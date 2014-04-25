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

if(!isset($_REQUEST["id"]) || empty($_REQUEST["id"])){
	header('Location: Error-Page?error=invalid program or event');
	die();
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

return;
