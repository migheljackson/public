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

var_dump($playlist);
$document_ids = array();

foreach ($playlist->playlist_items as $item) {

  array_push($document_ids, array('_type' => $item->playlist_item->item_type, '_id' => $item->playlist_item->item_type."_".$item->playlist_item->item_id));

}

var_dump($document_ids);

$es_result = COL::document_mget($document_ids);

var_dump($es_result);