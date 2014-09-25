<?php
/**
 *
 *
 * @name fe_show_popular_items
 * @description
 *
 */
$core_path = $modx->getOption( 'col_public.core_path', '', MODX_CORE_PATH.'components/col_public/' );
require_once $core_path.'col-library/col.php';

$popular_items_cache_key = "cache_popular_items";

// check the cache for the rendered items

$cached_str = $modx->cacheManager->get( $popular_items_cache_key );

if ( isset( $cached_str ) && !isset( $_REQUEST["reset_cache"] ) ) {
  return $cached_str;
} else {
  $piWidget = $modx->getOption( 'tpl', $scriptProperties, 'PopularItemsWidget' );
  $popular_item_response = COL::get( "/popular_items.json" );
  //var_dump( $popular_item_response );
  if ( $popular_item_response->status == 200 ) {

    $pop_items = $popular_item_response->result;
    // check the pathways and scheduled programs
    $render = false;

    if ( !empty( $pop_items->categories ) ) {
      $render = true;
      $category_list = '<ul id="topics" class="show-for-medium-up small-12 large-6 columns">';
      $category_list_slider = '<div id="topics_slider" class="show-for-small-only small-12 column">';
      foreach ( $pop_items->categories as $category ) {
        //var_dump($category);
        $category_list .= "<li><a href='/explore/?query=&cat_ids%5B%5D=". $category->category->item_id."'>".$category->category->name."</a></li>";
        $category_list_slider .= "<div class='small-12 small-centered'><a href='/explore/?query=&cat_ids%5B%5D=". $category->category->item_id."'>".$category->category->name."</a></div>";
      }
      $category_list .= '</ul>';
      $category_list_slider .= '</div>';

      //var_dump($category_list);
    }

    
    $document_ids = array();

    if ( !empty( $pop_items->programs ) ) {
      $render = true;
      foreach ( $pop_items->programs as $item ) {
        array_push( $document_ids, array( '_type' => "ScheduledProgram",
            '_id' => "ScheduledProgram_".$item->program->item_id ) );
      }
    }
    if ( !empty( $pop_items->challenges ) ) {
      $render = true;
      foreach ( $pop_items->challenges as $item ) {
        array_push( $document_ids, array( '_type' => "Pathway",
            '_id' => "Pathway_".$item->challenge->item_id ) );
      }
    }


    // if there are
    //var_dump( $document_ids );

    // request them from Elasticsearch
    $es_result = COL::document_mget( $document_ids );
    //var_dump( $es_result );
    // build the categories from chunk
    $activity_list = '<ul id="activities" class="show-for-medium-up medium-12 large-6 columns">';
    $activity_list_slider = '<div id="activities_slider" class="show-for-small-only small-12 columns">';
    foreach ( $es_result["docs"] as $doc ) {
      // code...
      if ( $doc["found"] ) {
        //var_dump($doc);
        // for each of the documents fill a featured item chunk
        $doc_details = $doc["_source"];

        if ($doc['_type']=="ScheduledProgram") {
          $href_details = '/'.$doc_details["program_type"].'-detail?id='.substr($doc["_id"], 17);
        } else {
          $href_details = '/challenges?id='.substr($doc["_id"],8);
        }
        
        $activity_list .= "<li><a href='".$href_details."'><img style='max-width:75px;' src='".$doc_details["logo_url"]."' alt='".$doc_details["name"]."' title='".$doc_details["name"]."'/></a></li>";
        $activity_list_slider .= "<div><a href='".$href_details."'><img style='max-height:12rem;' src='".$doc_details["logo_url"]."' alt='".$doc_details["name"]."' title='".$doc_details["name"]."'/></a></div>";
      }
    }
    $activity_list .= "</ul>";
    $activity_list_slider .= "</div>";
    //var_dump( $activity_list );
    $cached_str = $modx->getChunk( $piWidget, array('activity_list' => $activity_list, 'category_list' => $category_list, 'category_slider' => $category_list_slider, 'activity_slider' => $activity_list_slider));

    $modx->cacheManager->set( $featured_items_cache_key, $cached_str, 7200 ); // set for 2 hours
    return $cached_str;
  }
}