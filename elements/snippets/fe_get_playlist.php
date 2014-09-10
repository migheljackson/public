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

$playlist_response = COL::get("/playlists/1.json");
$playlist = $playlist_response->result;

// var_dump($playlist);

$modx->setplaceholder("playlist-name", $playlist->name);
$modx->setplaceholder("playlist-blurb", $playlist->blurb);
$modx->setplaceholder("playlist-description", $playlist->description);
$document_ids = array();

foreach ($playlist->playlist_items as $item) {
  array_push($document_ids, array('_type' => $item->playlist_item->item_type, '_id' => $item->playlist_item->item_type."_".$item->playlist_item->item_id));
}
// echo "\n<br/><br/>";
// var_dump($document_ids);

$es_result = COL::document_mget($document_ids);
$docs = $es_result["docs"];

// right now the ui calls for a new chunk - should revisit using existing chunk.
$srItemPathwayChunk = $modx->getOption('tpl', $scriptProperties, 'ExplorePlaylistItem');
for ($i = 0; $i < count($docs); $i++) {
	$pl_item = $modx->getChunk( $srItemPathwayChunk, $sp);
	$playlist_items .= $pl_item;
}
$modx->setplaceholder("playlist-items",$playlist_items);
// var_dump($es_result);