<?php
/**
 *
 *
 * @name fe_get_playlist
 * @description
 *
 */

// parameters from form
$core_path = $modx->getOption( 'col_public.core_path', '', MODX_CORE_PATH.'components/col_public/' );
require_once $core_path.'col-library/col.php';

$playlist_response = COL::get( "/playlists/".$playlist_id.".json" );
$playlist = $playlist_response->result;

// var_dump($playlist);

$modx->setplaceholder( "playlist-name", $playlist->name );
$modx->setplaceholder( "playlist-blurb", $playlist->blurb );
$modx->setplaceholder( "playlist-description", $playlist->description );
$modx->setplaceholder( "playlist-logo", $playlist->image_url );

$document_ids = array();

foreach ( $playlist->playlist_items as $item ) {
  array_push( $document_ids, array( '_type' => $item->playlist_item->item_type, '_id' => $item->playlist_item->item_type."_".$item->playlist_item->item_id ) );
}
// echo "\n<br/><br/>";
// var_dump($document_ids);

$es_result = COL::document_mget( $document_ids );
$docs = $es_result["docs"];

$badges_to_be_earned = array();

// right now the ui calls for a new chunk - should revisit using existing chunk.
$srItemPathwayChunk = $modx->getOption( 'tpl', $scriptProperties, 'ExplorePlaylistItem' );
//$srItemPathwayChunk = $modx->getOption('tpl', $scriptProperties, 'ExploreSearchResultItemPathway');
//$srItemScheduledProgramChunk = $modx->getOption('tpl', $scriptProperties, 'ExploreSearchResultItem');
for ( $i = 0; $i < count( $docs ); $i++ ) {
  $doc = $docs[$i];

  if ( $doc["found"] ) {
    $sp = $doc["_source"];
    $sp["id"] = substr( $sp["id"], 8 );

    $pl_item = $modx->getChunk( $srItemPathwayChunk, $sp );
    $playlist_items .= $pl_item;
    //var_dump($sp["badges"]);
    $badges_to_be_earned = array_merge( $badges_to_be_earned, $sp["badges"] ) ;
  }

}
$modx->setplaceholder( "playlist-items", $playlist_items );
$badge_summary_details = "";
if ( !empty( $badges_to_be_earned ) ) {
  //var_dump( $doc_details );
  $badge_details = "";
  foreach ( $badges_to_be_earned as $badge ) {
    $badge_details .= '<li><img src="'.$badge["image_url"].'" alt="'.$badge["name"].'" style="max-width: 75px;"></li>';

  }
  $badge_summary_details = '<h5>EARN BADGES</h5><ul class="small-12">'.$badge_details.'</ul>';
}
$modx->setplaceholder( "badge-items", $badge_summary_details );

//var_dump( $badges_to_be_earned );
// var_dump($es_result);