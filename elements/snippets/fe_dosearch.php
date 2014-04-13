<?php
/**
 *
 *
 * @name fe_dosearch
 * @description
 *
 */


// parameters from form
$core_path = $modx->getOption( 'col_public.core_path', '', MODX_CORE_PATH.'components/col_public/' );
require_once $core_path.'col-library/col.php';

if(isset($_REQUEST["zipcode"])) {
  $sql = "SELECT * FROM `col_zip` WHERE `zip` = ".$_REQUEST["zipcode"]." limit 1";

    $zip_info = $modx->query($sql);
    if($zip_info) {
      while ($row = $zip_info->fetch(PDO::FETCH_ASSOC)) {
        $latitude = $row["latitude"];
        $longitude = $row["longitude"];
        $range = "8km";

      }

    } else {
      $latitude = null;
      $longitude = null;
      $range = null;
    }

}
    
    


// price (s_price for the search p_price for whats passed in)
$s_price = null;
$p_price = $_REQUEST["price"];
if ( isset( $p_price )  && strlen( $p_price ) > 0 ) {
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

$searchResults = COL::search( $s_query, $s_cat_ids, $s_min_age, $s_max_age, $s_price, array(), $s_page, $pageSize, $latitude, $longitude, $range );

// check for total
$paging = '';
if ( $searchResults['hits']['total'] >  $pageSize ) {
  $aPageLinks = array();

  $iCurrentPage = intval( $p_page );
  $plChunk = $modx->getOption( 'tpl', $scriptProperties, 'ExploreSearchResultsPagingLink' );
  $cplChunk = $modx->getOption( 'tpl', $scriptProperties, 'ExploreSearchResultsPagingCurrent' );
  $plsChunk = $modx->getOption( 'tpl', $scriptProperties, 'ExploreSearchResultsPaging' );


  $iTotalPages = intval( ceil( $searchResults['hits']['total'] / $pageSize ) );

  // if we are on the first page do not show previous
  if ( $iCurrentPage == 0 ) {

  } else {
    // subtract 1 from the page number and create link and add to pagelinks
    $iBackPage = $iCurrentPage - 1;
    $l =  $modx->getChunk( $plChunk, array( 'page_num' => $iBackPage, 'page_num_title' => "Prev" ) );
    array_push( $aPageLinks , $l );
  }

  $initialPageNum = 0;
  // if page number is greater than 6
  if ( $iCurrentPage > 5 ) {
    // set first page num to page - 5
    $initialPageNum = $iCurrentPage - 5;
  }

  $iFinalPageNum = $initialPageNum + 10;
  // for 10 links
  for ( $i = $initialPageNum; $i < $iFinalPageNum; ++$i ) {
    // if we are on the current page
    if ( $iCurrentPage==$i ) {
      // create a current page link
      $l = $modx->getChunk( $cplChunk, array( 'page_num' => $i, 'page_num_title' => strval( $i+1 ) ) );
      array_push( $aPageLinks , $l );
    } else {
      // if the page is less than the total pages
      // create page link
      // add to links array
      if ( $i < $iTotalPages ) {
        $l =  $modx->getChunk( $plChunk, array( 'page_num' => $i, 'page_num_title' => strval( $i+1 ) ) );
        array_push( $aPageLinks , $l );
      } else {
        break;
      }
    }


  }
   // if we are not on the last page
    // add next page link
    

  if ( $iCurrentPage != ( $iTotalPages-1 ) ) {
      $l =  $modx->getChunk( $plChunk, array( 'page_num' => $iCurrentPage+1, 'page_num_title' => "Next" ) );
      array_push( $aPageLinks , $l );
    }


$paging = $modx->getChunk( $plsChunk, array( "paging_link_items" => implode( "", $aPageLinks ) ) );

}



if (  $searchResults['hits']['total'] > 0 ) {
  $modx->setPlaceholder( "hit_count", strval( $searchResults['hits']['total'] ) );
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
  $results = $modx->getChunk( $srChunk, array( 'search_result_items'=>$items, 'paging' => $paging ) );

  //print_r($results);
  return $results;

} else {
  return "No items found";
}