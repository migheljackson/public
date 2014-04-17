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
if(!isset($_REQUEST["id"]) || empty($_REQUEST["id"])){
	header('Location: Error-Page?error=invalid program or event');
	die();
}

$workshop = $modx->runSnippet("getScheduledItem", array("scheduled_id" => $_REQUEST["id"]));

$relatedItemCountMax = 5;
$relatedTpl = $modx->getOption( 'tpl', $scriptProperties, 'WorkshopRelatedWorkshops' );
$relatedItemTpl = $modx->getOption( 'tpl', $scriptProperties, 'WorkshopRelatedItem' );

if ( isset( $workshop["latitude"] ) && isset( $workshop["longitude"] ) ) {
	//$searchResults = COL::search( $s_query, $s_cat_ids, $s_min_age, $s_max_age, $s_price, $s_locations, $s_page, $pageSize, $latitude, $longitude, "5km" );

	$searchResults = COL::search( "", null, null, null, null, null, 0, $relatedItemCountMax+1, $workshop["latitude"], $workshop["longitude"], "3km" );

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
			


			if ( $sp["id"] != $workshop["id"] ) {
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

// print_r($searchResults);
return;
