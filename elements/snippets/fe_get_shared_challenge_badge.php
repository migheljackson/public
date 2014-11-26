<?php
/**
 *
 *
 * @name fe_get_shared_challenge_badge
 * @description takes a url passed to it, loads it 
 *
 */



// check if the url parameter and make sure its an iremix.cc
$evidence_url = $_REQUEST["e"];
if (strpos($evidence_url, "iremix.cc")===false) {
  // if not return invalid page message
  return "There was an error with this page. Are you sure the url is correct?";
} else {

  $modx->regClientCSS('//cdnjs.cloudflare.com/ajax/libs/jplayer/2.7.1/skin/blue.monday/jplayer.blue.monday.min.css');
  $modx->regClientScript('//cdnjs.cloudflare.com/ajax/libs/jplayer/2.7.1/jquery.jplayer/jquery.jplayer.min.js');

/*
  $ogmtChunk = $modx->getOption( 'tpl', $scriptProperties, 'OpenGraphMetaTags' );
  $ogmt_content=  $modx->getChunk($ogmtChunk, $share_options);
  $modx->regClientStartupHTMLBlock($ogmt_content);
*/
  
  $cache_key = 'cb_'.$evidence_url;
  // check if url has cache key
  $cached_str = $modx->cacheManager->get( $cache_key );
  
  if ( isset( $cached_str ) && !isset( $_REQUEST["reset_cache"] ) ) {
    // if so return cached value
    return $cached_str;
  } else {
    // if not
    $contents = file_get_contents($evidence_url);
    // cache the content
    $modx->cacheManager->set( $cache_key, $contents, 720000 ); // set for 200 hours
     
    return $contents;
    // return content
  }
}