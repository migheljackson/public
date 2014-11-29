<?php
/**
 *
 *
 * @name fe_get_shared_badge
 * @description takes a url passed to it, loads it 
 *
 */

$core_path = $modx->getOption( 'col_public.core_path', '', MODX_CORE_PATH.'components/col_public/' );
require_once $core_path.'col-library/col.php';

// get the shared badge hash and check the cache to see if its loaded
$shared_badge_hash = $_REQUEST["ibh"];
if(!isset($shared_badge_hash)) {
  return "There was an error with this page. Are you sure the url is correct?";
} else {

  // check for the hash in the cache
  $cache_key = 'sb_'.$shared_badge_hash;

  // check if url has cache key
  $cached_str = $modx->cacheManager->get( $cache_key );
  
  if ( isset( $cached_str ) && !isset( $_REQUEST["reset_cache"] ) ) {
    // if so return cached value
    return $cached_str;
  } else {
    // load the badge 
    $ibadge_result = COL::getIssuedBadgeByHash($shared_badge_hash);
    $ibadge = $ibadge_result->result;
    //var_dump($ibadge);

    $badge_details = array('username' => $ibadge->user_detail, );
    $badge_details["badge"] = $ibadge->badge_details;
    $badge_details["badge_url"] = $ibadge->badge_image_url;
    var_dump($ibadge);
    $earned_on = new DateTime($ibadge->awarded_at);
    $badge_details["earned_on"] = $earned_on->format("M j, o");
    

    /*
    $ogmtChunk = $modx->getOption( 'tpl', $scriptProperties, 'OpenGraphMetaTags' );
    $ogmt_content=  $modx->getChunk($ogmtChunk, $share_options);
    $modx->regClientStartupHTMLBlock($ogmt_content);
    
    */
    //var_dump($ibadge->result->badge_details);
    // build contents for each badge type
    if ($ibadge->badge_details->badge_type ==="challenge") {
      //var_dump("Challenge");
      $modx->regClientCSS('//cdnjs.cloudflare.com/ajax/libs/jplayer/2.7.1/skin/blue.monday/jplayer.blue.monday.min.css');
      $modx->regClientScript('//cdnjs.cloudflare.com/ajax/libs/jplayer/2.7.1/jquery.jplayer/jquery.jplayer.min.js');
      //var_dump($ibadge);
      $evidence_url = $ibadge->evidences[0]->evidence->url;

      $contents = file_get_contents($evidence_url);


    } else if ($ibadge->badge_details->badge_type ==="meta") {
      // load up the chunks
       
    } else {
      if(!empty($ibadge->evidences)) {
        $evidence_prefix = '<div class="small-12 large-4 end">';
        $evidence_suffix = '</div>';
        $evidence_body = '';
        foreach($ibadge->evidences as $evidence) {
          $evidence_body .= '<a href="'.$evidence->$evidence->url.'" class="button small radius expand">View my evidence ></a>';
        }

        $badge_details["evidence_links"] = $evidence_prefix.$evidence_body.$evidence_suffix;
      }

      if(!empty($ibadge->badge_details->badge_criteria)) {
        $output = '<div class="row"> <div class="small-12 columns"> <p><strong>Criteria:</strong></p> </div> <div class="small-12 columns"> <ol>'; 

        foreach($ibadge->badge_details->badge_criteria as $item) {
          $output.="<li>";
          if($item->required==true){
            $output.="[required] ";
          }
          $output.= $item->description.'</li>'; 
        }
        $output.='</ol></div></div><div class="row"> <div class="show-for-small panel"> <a href="">See badge criteria <i class="fa fa-caret-right"></i></a> </div>'; 
        $modx->setPlaceholder("criteria", $output);
        $badge_details["badge_criteria"] = $output;
      }

      if(!empty($ibadge->scheduled_program->categories)) {
        $categories = array();
        foreach($ibadge->badge_details->categories as $cat) { 
          if(!in_array($cat->name, $categories)) {
            array_push($categories, $cat->name);
          }
        }
        $badge_details["scheduled_program_categories"] = implode(",", $categories);
      }

      $badge_details["org"] = $ibadge->org;
      $badge_details["scheduled_program"] = $ibadge->scheduled_program;

      // load up the chunk
      $contentsChunk = $modx->getOption( 'tpl', $scriptProperties, 'SharedOrgBadge' );
      $contents = $modx->getChunk($contentsChunk, $badge_details);
        
    }

    /*
    // cache the content
    $modx->cacheManager->set( $cache_key, $contents, 720000 ); // set for 200 hours
     */
    return $contents;
    
    

  }

}