<?php
/**
 *
 *
 * @name fe_show_featured_items
 * @description
 *
 */
$core_path = $modx->getOption( 'col_public.core_path', '', MODX_CORE_PATH.'components/col_public/' );
require_once $core_path.'col-library/col.php';

$featured_items_cache_key = "cache_featured_items";

// check the cache for the rendered items

$cached_str = $modx->cacheManager->get( $featured_items_cache_key );

if ( isset( $cached_str ) && !isset( $_REQUEST["reset_cache"] ) ) {
  return $cached_str;
} else {
  $featured_item_response = COL::get( "/featured_items.json" );
  //var_dump($featured_item_response);
  $document_ids = array();
  if ( $featured_item_response->status == 200 ) {
    foreach ( $featured_item_response->result as $item ) {

      array_push( $document_ids, array( '_type' => $item->item_type,
          '_id' => $item->item_type."_".$item->item_id ) );

    }
    //var_dump($document_ids);

    if ( !empty( $document_ids ) ) {

      $fiWidget = $modx->getOption( 'tpl', $scriptProperties, 'FeaturedItemWidget' );
      $fiGroup = $modx->getOption( 'tpl', $scriptProperties, 'FeaturedItemGroup' );
      $fiScheduledProgram = $modx->getOption( 'tpl', $scriptProperties, 'FeaturedItemScheduledProgram' );
      $fiChallenge = $modx->getOption( 'tpl', $scriptProperties, 'FeaturedItemChallenge' );

      $es_result = COL::document_mget( $document_ids );
      //var_dump($es_result);
      $fi_snippets = array();

      foreach ( $es_result["docs"] as $doc ) {
        // code...
        if ( $doc["found"] ) {

          // for each of the documents fill a featured item chunk
          $doc_details = $doc["_source"];

          if ( $doc["_type"] == "ScheduledProgram" ) {

            $doc_details["short_description"] = substr( $doc_details["description"], 0, 80 )."...";

            // <strong>July 23-Aug 2, Mo-Wed <br> Downtown</strong>

            $start_date = "";
            if ( $doc_details['start_date']!=null ) {
              $startDateTime = new DateTime( $doc_details['start_date'] );
              $start_date = $startDateTime->format( "M d" );
            }
            $end_date = "";
            if ( $doc_details['end_date']!=null ) {
              $endDateTime = new DateTime( $doc_details['end_date'] );
              $end_date = $endDateTime->format(  "M d" );
            }

            if ( strlen( $start_date ) > 0 && strlen( $end_date ) > 0 ) {
              $date_details = $start_date."-".$end_date;
            } else {
              $date_details = $start_date.$end_date;
            }

            $day_details = array();
            if ( $doc_details["scheduled_mon"] ) {
              array_push( $day_details, "Mon" );
            }

            if ( $doc_details["scheduled_tue"] ) {
              array_push( $day_details, "Tue" );
            }
            if ( $doc_details["scheduled_wed"] ) {
              array_push( $day_details, "Wed" );
            }
            if ( $doc_details["scheduled_thurs"] ) {
              array_push( $day_details, "Thurs" );
            }

            if ( $doc_details["scheduled_fri"] ) {
              array_push( $day_details, "Fri" );
            }

            if ( $doc_details["scheduled_sat"] ) {
              array_push( $day_details, "Sat" );
            }
            if ( $doc_details["scheduled_sun"] ) {
              array_push( $day_details, "Sun" );
            }
            $day_str_details = "";
            if ( !empty( $day_details ) ) {
              $day_str_details = implode( ',', $day_details );
            }

            if ( strlen( $date_details ) > 0 && strlen( $day_str_details ) > 0 ) {
              $doc_details["location_details"] = "<strong>".$date_details.", ".$day_str_details."<br>".$doc_details["org_name"] ."</strong>";
            } else if ( strlen( $date_details ) == 0 && strlen( $day_str_details ) == 0 ) {
                $doc_details["location_details"] = "<strong>".$doc_details["org_name"]."</strong>";
              } else {
              $doc_details["location_details"] = "<strong>".$date_details.$day_str_details."<br>".$doc_details["org_name"] ."</strong>";
            }

            if ( !empty( $doc_details["badges"] ) ) {
              //var_dump( $doc_details );
              $badge_details = "";
              $counter=0;
              foreach ( $doc_details["badges"] as $badge ) {
                $badge_details .= '<li><img src="'.$badge["image_url"].'" alt="'.$badge["name"].'"></li>';
                $counter+=1;
                if($counter==4){break;}
              }
              $doc_details["badge_details"] = '<h6>EARN BADGES</h6><ul class="small-12 medium-12 large-12 columns item-badges">'.$badge_details.'</ul>';
            }
            $fi_detail = $modx->getChunk( $fiScheduledProgram, $doc_details );
            array_push( $fi_snippets, $fi_detail );

          } else if ( $doc["_type"] == "Pathway" ) {
              //var_dump( $doc_details );
              $doc_details["short_description"] = substr( $doc_details["blurb"], 0, 80 )."...";

              if ( !empty( $doc_details["badges"] ) ) {
                $badge_details = "";
                foreach ( $doc_details["badges"] as $badge ) {
                  $badge_details .= '<li><img src="'.$badge["image_url"].'" alt="'.$badge["name"].'"></li>';

                }
                $doc_details["badge_details"] = '<h6>EARN BADGES</h6><ul class="small-12 medium-12 large-12 columns item-badges">'.$badge_details.'</ul>';

              }

              $fi_detail = $modx->getChunk( $fiChallenge, $doc_details );
              array_push( $fi_snippets, $fi_detail );
            }

        }
      }
      //var_dump($fi_snippets);
      $widget_details = "";
      $group_details = "";
      for ( $i=0; $i < count( $fi_snippets ); $i++ ) {

        // for 3 featured item chunks fill a featured item group chunk
        if ( $i % 3 == 0 ) {
          if ( strlen( $group_details ) > 0 ) {
            // render the group details into the group chunk
            $group_widget = $modx->getChunk( $fiGroup , array( 'feature_items' => $group_details ) );
            // save the current group to the widget details
            $widget_details .= $group_widget;
          }
          $group_details = "";
        }

        $group_details .= $fi_snippets[$i];

      }

      if ( strlen( $group_details ) > 0 ) {

        // render the group details into the group chunk
        $group_widget = $modx->getChunk( $fiGroup , array( 'feature_items' => $group_details ) );
        // save the current group to the widget details
        $widget_details .= $group_widget;
      }

      $all_fi_items = implode("", $fi_snippets);

      // for the featured item widget fill in all the group chunks
      $featured_widget = $modx->getChunk( $fiWidget , array( 'featured_item_groups' => $widget_details, 'all_featured_items' => $all_fi_items ) );
      // save the final widget to the cache
      $modx->cacheManager->set( $featured_items_cache_key, $featured_widget, 7200 ); // set for 2 hours
      // return final widget
      return $featured_widget;



    }


  }


}