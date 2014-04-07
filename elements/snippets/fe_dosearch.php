<?php
// parameters from form
$core_path = $modx->getOption( 'col_public.core_path', '', MODX_CORE_PATH.'components/col_public/' );
require_once $core_path.'col-library/col.php';


// price (s_price for the search p_price for whats passed in)
$s_price = null;
$p_price = $_REQUEST["price"];
if ( isset( $p_price )  && strlen( $p_price )) {
  if ( $p_price == "paid" ) {
    $s_price = true;
  } else {
    $s_price = false;
  }
}

// querystring
$s_query = "";
$p_query =  $_REQUEST["query"];
if ( isset( $p_query ) && strlen( $p_query ) ) {
  $s_query = $p_query;
}

$s_page = "";
$p_page =  $_REQUEST["page"];
if ( isset( $p_page ) && strlen( $p_page ) ) {
  $s_page = $p_page;
}

// cat_ids
$s_cat_ids = array();
$p_cat_ids = $_REQUEST["cat_ids"];


if ( !is_null( $p_cat_ids ) && is_array( $p_cat_ids ) ) {
  $s_cat_ids = $p_cat_ids;
}

$s_min_age = 0;
$s_max_age = 100;
$p_age_range = $_REQUEST["age_range"];
// age_range
if ( isset( $p_age_range ) ) {
  $parts = explode( "-", $p_age_range );
  $s_min_age = intval( $parts[0] );
  $s_max_age = intval( $parts[1] );
}

$pageSize = 15;

$searchResults = COL::search( $s_query, $s_cat_ids, $s_min_age, $s_max_age, $s_price, array(), $s_page, $pageSize );

// check for total

if ( count( $searchResults['hits']['hits'] ) == $pageSize ) {
  // show laod more button
}



if (  $searchResults['hits']['total'] > 0 ) {
  $modx->setPlaceholder("hit_count", strval($searchResults['hits']['total']));
  $items = '';
  $srItemChunk = $modx->getOption( 'tpl', $scriptProperties, 'ExploreSearchResultItem' );
  $srSchoolsChunk = $modx->getOption( 'tpl', $scriptProperties, 'ExploreSearchResultSchoolItem' );
  $srCategoriesChunk = $modx->getOption( 'tpl', $scriptProperties, 'ExploreSearchResultCategoryItem' );
  foreach ( $searchResults['hits']['hits'] as $hit ) {
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

    $schoolLinks = array();
    $iMinAge = $sp['min_age'];
    $iMaxAge = $sp['max_age'];

    if ( $sp['price']>0 ) {
      $sp['price'] = '$';
    } else {
      $sp['price'] = 'Free';
    }

    if ( $iMinAge < 5 ) {
      array_push( $schoolLinks, $modx->getChunk( $srSchoolsChunk, array( 'age_range' => '2-5', 'school' => 'Pre-School' ) ) );
    }
    if ( $iMaxAge > 5 ) {
      if ( $iMinAge < 12 ) {
        array_push( $schoolLinks, $modx->getChunk( $srSchoolsChunk, array( 'age_range' => '5-12', 'school' => 'Elementary' ) ) );
      }
      if ( $iMaxAge > 12 ) {
        if ( $iMinAge < 18 ) {
          array_push( $schoolLinks, $modx->getChunk( $srSchoolsChunk, array( 'age_range' => '12-18', 'school' => 'Middle & High School' ) ) );
        }


        if ( $iMaxAge > 18 ) {

          array_push( $schoolLinks, $modx->getChunk( $srSchoolsChunk, array( 'age_range' => '18-24', 'school' => 'Young Adults' ) ) );
        }


      }
    }



    $sp["schools"] = implode( ",&nbsp;", $schoolLinks );

    $cats = array();
    foreach ( $sp['categories'] as $cat ) {
      // code...
      array_push( $cats, $modx->getChunk( $srCategoriesChunk, $cat ) );
    }

    $sp["categories_links"] = implode( ",&nbsp;", $cats );

    $items .= $modx->getChunk( $srItemChunk, $sp );
  }



  $srChunk = $modx->getOption( 'tpl', $scriptProperties, 'ExploreSearchResults' );
  $results = $modx->getChunk( $srChunk, array( 'search_result_items'=>$items ) );

  //print_r($results);
  return $results;

} else {
  return "No items found";
}