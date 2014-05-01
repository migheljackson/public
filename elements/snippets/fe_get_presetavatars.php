<?php
/**
 *
 *
 * @name fe_get_presetavatars
 * @description
 *
 */

// parameters from form
$core_path = $modx->getOption( 'col_public.core_path', '', MODX_CORE_PATH.'components/col_public/' );
require_once $core_path.'col-library/col.php';

$response = COL::system_get('/preset_avatars.json');

$paChunk = $modx->getOption( 'tpl', $scriptProperties, 'AvatarListItem' );

$avatars_output = '';
for ($i = 0; $i < count($response->result); $i++) {
  $preset_avatar = $response->result[$i];
  $avatars_output .= $modx->getChunk( $paChunk, array('preset_avatar_id' => $preset_avatar->id, 'image_url' => $preset_avatar->image_url));
}

$modx->setPlaceholder( 'avatar_items', $avatars_output );