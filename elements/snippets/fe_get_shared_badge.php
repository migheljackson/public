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
  $site_url = $modx->getOption('site_url');
  $url = $site_url.$_REQUEST["q"].'?ibh='.$shared_badge_hash;
  $site_name = $modx->getOption('site_name');
  
  // check for the hash in the cache
  $cache_key = 'sb_'.$shared_badge_hash;

  
  $page_title_ck = $cache_key."_page_title"; 
  $page_image_url_ck = $cache_key."_page_image_url"; 
  $page_description_ck = $cache_key."_page_description"; 

  // check if url has cache key
  $cached_str = $modx->cacheManager->get( $cache_key );
  var_dump($site_name);
  if ( isset( $cached_str ) && !isset( $_REQUEST["reset_cache"] ) ) {
    // load the open graph details here
    $omgtDetails = array();
    
    $omgtDetails["page_title"] = $modx->cacheManager->get( $page_title_ck );
    $omgtDetails["page_url"] = $url;
    $omgtDetails["page_image_url"] = $modx->cacheManager->get( $page_image_url_ck );
    $omgtDetails["page_description"] = $modx->cacheManager->get( $page_description_ck );
    $omgtDetails["site_name"] = $site_name;


    $ogmtChunk = $modx->getOption( 'tpl', $scriptProperties, 'OpenGraphMetaTags' );
    $ogmt_content=  $modx->getChunk($ogmtChunk, $omgtDetails);
    $modx->regClientStartupHTMLBlock($ogmt_content);

    // if so return cached value
    return $cached_str;
  } else {
    $site_url = $modx->getOption('site_url');
    // load the badge 
    $ibadge_result = COL::getIssuedBadgeByHash($shared_badge_hash);
    $ibadge = $ibadge_result->result;
    var_dump($ibadge);

    $badge_details = array('username' => $ibadge->user_detail, );
    $badge_details["badge"] = $ibadge->badge_details;
    $badge_details["badge_url"] = $ibadge->badge_image_url;
    //var_dump($ibadge);
    $earned_on = new DateTime($ibadge->awarded_at);
    $badge_details["earned_on"] = $earned_on->format("M j, o");
    
    $omgtDetails = array();

    $page_description = $ibadge->badge_details->description;
    
    $omgtDetails["page_title"] = $ibadge->user_detail." earned the ".$sbadge["name"]." badge. ";
    $omgtDetails["page_url"] = $url;
    $omgtDetails["page_image_url"] = $ibadge->badge_image_url;
    $omgtDetails["page_description"] = $page_description;
    $omgtDetails["site_name"] = $site_name;

    $content_options = array('page_description', 'page_title');

    $m = new Mustache_Engine;
    $social_args = array('badge_name' => $ibadge->badge_details->name, 'user_detail' => $ibadge->user_detail );
    foreach ($content_options as $content_key) {
      # code...
      $content_template = $modx->getOption('badge_share_'.$content_key);
      
      if(isset($content_template) && !empty($content_template)) {
        $omgtDetails[$content_key] = $m->render($content_template, $social_args);
      } 
    }
    

    //cache the og tags
    $modx->cacheManager->set( $page_title_ck, $omgtDetails["page_title"], 720000 ); // set for 200 hours
    $modx->cacheManager->set( $page_image_url_ck, $ibadge->badge_image_url, 720000 ); // set for 200 hours
    $modx->cacheManager->set( $page_description_ck, $omgtDetails["page_description"], 720000 ); // set for 200 hours

    $ogmtChunk = $modx->getOption( 'tpl', $scriptProperties, 'OpenGraphMetaTags' );
    $ogmt_content=  $modx->getChunk($ogmtChunk, $omgtDetails);
    $modx->regClientStartupHTMLBlock($ogmt_content);
    
    
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
      $contentsChunk = $modx->getOption( 'tpl', $scriptProperties, 'SharedCityBadge' );
      if(!empty($ibadge->issued_badges_evidence)) {
        $index = 0;
        
        $evidenceChunk = $modx->getOption( 'tpl', $scriptProperties, 'SharedCityBadgeEarnedBadge' );
        $evidenceTabChunk = $modx->getOption( 'tpl', $scriptProperties, 'SharedCityBadgeEarnedBadgeTab' );

        $evidence_tabs = '';
        $evidence_panels = '';
        foreach($ibadge->issued_badges_evidence as $issued_badge) {
          $evidence_body = '';
          foreach($issued_badge->evidences as $evidence) {
            $evidence_url = $evidence->url;
            //var_dump($evidence);
            //var_dump($issued_badge->badge_type);
            if($issued_badge->badge_type === "challenge") {
              $evidence_body .= '<a target="_blank" href="'.$site_url.'/shared-challenge-badge?ibh='.$issued_badge->shared_badge_hash.'" class="button small radius">View the submission ></a>';
            } else {
              $evidence_url = filter_var($evidence_url, FILTER_SANITIZE_STRING);
              //var_dump($evidence_url);
              if(strlen($evidence_url) > 0) {
                $evidence_body .= '<a target="_blank" href="'.$evidence_url.'" class="button small radius">View the submission ></a>';  
              }
              
            }
          }
          $issued_badge->index = $index;
          $issued_badge->submission_links = $evidence_body;
          $issued_badge->index = $index;
          
          if ($index===0) {
            $issued_badge->active = "active";
          } else {
            $issued_badge->active = "";
          }

          $earned_on = new DateTime($issued_badge->awarded_at);
          $issued_badge->earned_on = $earned_on->format("M j, o");


          //var_dump($issued_badge);
          $evidence_tabs .= $modx->getChunk($evidenceTabChunk, (array) $issued_badge);
          $evidence_panels .= $modx->getChunk($evidenceChunk, (array) $issued_badge);

          $index += 1;
        }

        $badge_details["evidence_panels"] = $evidence_panels;
        $badge_details["evidence_tabs"] = $evidence_tabs;
        //var_dump($badge_details);
      }

      $contents = $modx->getChunk($contentsChunk, $badge_details);
       
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

    
    // cache the content
    $modx->cacheManager->set( $cache_key, $contents, 720000 ); // set for 200 hours
     
    return $contents;
    
    

  }

}