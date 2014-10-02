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

    // build answers map to questions
    $custom_questions_answers = array();
    $answer_count = count($response->result->custom_question_answers);
    for($j = 0; $j < $answer_count; $j++) {
      $cqa = $response->result->custom_question_answers[$j];
      $custom_questions_answers[$cqa->custom_question_id] = $cqa->response_text;
    }

    // build custom questions
    $custom_questions_text = '';
    $question_count = count($response->result->custom_questions);
    //var_dump($response->result->custom_questions);
    $radioCQChunk = $modx->getOption( 'tpl', $scriptProperties, 'CustomQuestionRadio');
    $freeCQChunk = $modx->getOption( 'tpl', $scriptProperties, 'CustomQuestionFreeForm');
    $selectCQChunk = $modx->getOption( 'tpl', $scriptProperties, 'CustomQuestionSelect');
    for($j = 0; $j < $question_count; $j++) {
      $cq = $response->result->custom_questions[$j];

      $custom_question_text = "";

      $custom_question_details = array('question' => $cq->external_description );
      $possible_answer_count = count($cq->choices);
      if($cq->answer_type == "boolean" || ($cq->answer_type == "single_select" && $possible_answer_count < 4)) {
        // Radio
        if($cq->answer_type == "boolean") {
          $choices = array("true", "false");
          $possible_answer_count = 2;
        } else {
          $choices = $cq->choices;
        }
        $answers = "";
        for($k = 0; $k < $possible_answer_count; $k++) {
          $pa = $choices[$k];
          $element_id = 'cq_'.strval($cq->id).'_'.$pa;
          $answer = '<input type="radio" name="custom_question_answers['.strval($cq->id).
          ']" value="'.$pa.'" id="'.$element_id.'"';

          if(isset($custom_questions_answers[$cq->id])) {
            if ($custom_questions_answers[$cq->id] == $pa) {
              $answer.= " checked ";
            }
          }
          
          $suffix = ' /><label for="'.$element_id.'">'.$pa.'</label>';
          $answers .= $answer.$suffix;
        }
        $custom_question_details['answer_options'] = $answers;

        $custom_question_text = $modx->getChunk($radioCQChunk, $custom_question_details);
        
      } else if ($cq->answer_type == "free_form") {
        // Free form
        if(isset($custom_questions_answers[$cq->id])) {
            $custom_question_details["answer"] = $custom_questions_answers[$cq->id];
        }
        $custom_question_details["custom_question_id"] = strval($cq->id);

        $custom_question_text = $modx->getChunk($freeCQChunk, $custom_question_details);

      } else {
        // select
        $answers = "<option></option>";
        $custom_question_details["custom_question_id"] = strval($cq->id);
        $possible_answer_count = count($cq->choices);
        //var_dump($cq->choices);
        for($k = 0; $k < $possible_answer_count; $k++) {
          $pa = $cq->choices[$k];
          //var_dump($pa);
          $element_id = 'cq_'.strval($cq->id).'_'.$pa;
          $answer = '<option value="'.$pa.'"' ;

          if(isset($custom_questions_answers[$cq->id])) {
            if ($custom_questions_answers[$cq->id] == $pa) {
              $answer.= " selected ";
            }
          }
          
          $suffix = ' />'.$pa.'</option>';
          $answers .= $answer.$suffix;
        }
        $custom_question_details['answer_options'] = $answers;

        $custom_question_text = $modx->getChunk($selectCQChunk, $custom_question_details);
      }
      
      $custom_questions_text .= $custom_question_text;

    }
    //var_dump($custom_questions_text);

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
      'guardian_phone' => $response->result->guardian_phone,
      'custom_questions' => $custom_questions_text
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