<?php
/**
 *
 *
 * @name fe_get_profile
 * @description
 *
 */

// parameters from form
$core_path = $modx->getOption( 'col_public.core_path', '', MODX_CORE_PATH.'components/col_public/' );
require_once $core_path.'col-library/col.php';
require_once $core_path.'col-library/col_user.php';

if (COL::is_signed_in()) {
  $response = COL_User::get_profile();

  COL::log_action('view_profile', array( 'extra_params' => array('status' =>  $response->status)));
  //var_dump($response);

  if ($response->status == 200) {
    $badge_count = count($response->result->issued_badges);
    $badge_items = "";
    $activities_count = count($response->result->scheduled_programs);
    $activities_items = "";

    $bChunk = $modx->getOption( 'tpl', $scriptProperties, 'ProfileBadgeItem' );
    // $extBChunk = $modx->getOption('tpl', $scriptProperties, 'ProfileBadgeItemExternal');
  	for($i = 0; $i < $badge_count; $i++) {
      $badge = $response->result->issued_badges[$i];
      $badgeAwarded = new DateTime( $badge->issued_badge->awarded_at );
      $badge_awarded_at = $badgeAwarded->format( "m/d/Y" );
      $badge_sort = $badgeAwarded->format( "Y/m/d A g:i " );
      $badge_items .= $modx->getChunk($bChunk, array('sort_awarded_at' =>  $badge_sort, 'awarded_at' => $badge_awarded_at, 'badge_name' => $badge->issued_badge->badge_name,
		'badge_image_url' => $badge->issued_badge->badge_image_url, 'badge_id' => $badge->issued_badge->badge_id ));
    }

    //var_dump($badge_items);
    $aChunk = $modx->getOption( 'tpl', $scriptProperties, 'ProfileActivityItem' );
    for($i = 0; $i < $activities_count; $i++) {
      $workshop = $response->result->scheduled_programs[$i]->scheduled_program;
      $startDateTime = new DateTime( $workshop->start_date);
      $workshop_start_date = $startDateTime->format( "m/d/Y" );
      $workshop_sort_sd = $startDateTime->format( "Y/m/d" );
      $endDateTime = new DateTime( $workshop->end_date);
      $workshop_end_date = $endDateTime->format( "m/d/Y" );

      $params = array('sort_start_date' => $workshop_sort_sd, 'start_date' => $workshop_start_date, 'end_date' => $workshop_end_date,
        'id' => strval($workshop->id), 'name' => $workshop->name, 'image_url' => $workshop->logo_url
        );

      $activities_items .= $modx->getChunk($aChunk, $params);
    }

    $placeholders = array('username' => $response->result->username,
      'preset_avatar_url' => $response->result->preset_avatar_url,
      'badge_count' => strval($badge_count),
      'badge_items' => $badge_items,
      'activities_count' => strval($activities_count),
      'activities_items' => $activities_items,
      'user_id' => $response->result->id,
      'full_name' => $response->result->full_name,
      'date_of_birth' => $response->result->date_of_birth,
      'email_address' =>  $response->result->email_address, 
      'guardian_name' => $response->result->guardian_name, 
      'guardian_email_address' => $response->result->guardian_email_address, 
      'guardian_phone' => $response->result->guardian_phone
      );

    $modx->setPlaceholders($placeholders);
    $jwt = COL::_get_jwt_token();
    $modx->setPlaceholder('jwt', $jwt);
  } else {
    header('Location: sign-in');
    die();
  }
} else {
  header('Location: sign-in');
  die();
}
