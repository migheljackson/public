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

// contact chunk
if ( $workshop['contact_name']!=null || $workshop['contact_email']!=null || $workshop['contact_phone']!=null || $workshop['program_url']!=null ) {
	$workshopContact = '<li><h4 class="event-block-title center">workshop contact</h4><div class="event-block clearfix">';
	// add name if it exists
	if ( $workshop['contact_name'] ) {
		$workshopContact .= '<div class="row"><div class="small-6 large-12 columns"><a href="#" class="user"><img src="http://placehold.it/30x30&text=avatar" alt="avatar">
[[+contact_name]]</a></div></div>';
	}

	if ( $workshop['contact_email'] ) {
		$workshopContact .= '<div class="row"><div class="small-6 large-12 columns"><a href="#" class="user"><img src="http://placehold.it/30x30&text=avatar" alt="avatar">
[[+contact_email]]</a></div></div>';
	}

	if ( $workshop['contact_phone'] ) {
		$workshopContact .= '<div class="row"><div class="small-6 large-12 columns"><a href="#" class="user"><img src="http://placehold.it/30x30&text=avatar" alt="avatar">
[[+contact_phone]]</a></div></div>';
	}

	if ( $workshop['program_url'] ) {
		$workshopContact .= '<div class="row"><div class="small-6 large-12 columns"><a href="#" class="user">[[+program_url]]</a></div></div>';
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

// $workshop['end_date'] = $endDateTime->format("g:i A");
$modx->setPlaceholders( $workshop );


/* example call to search
 $org_id = 14;
$program_id = 118;
$scheduled_program_id = 143;

// $searchResults = COL::search("yoga", null , 2, 22, null, null, 1, 15);
*/

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
