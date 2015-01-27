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

if (!COL::is_signed_in()) {
	header('Location: sign-in');
	die();
}

$response = COL::system_get('/preset_avatars.json');

$paChunk = $modx->getOption( 'tpl', $scriptProperties, 'AvatarListItem' );

$avatars_output = '';
for ($i = 0; $i < count($response->result); $i++) {
  $preset_avatar = $response->result[$i];
  $avatars_output .= $modx->getChunk( $paChunk, array('preset_avatar_id' => $preset_avatar->id, 'image_url' => $preset_avatar->image_url));
}

$modx->setPlaceholder( 'avatar_items', $avatars_output );

$cqResponse = COL::get('/custom_questions.json');
//var_dump($cqResponse);

// build custom questions
$custom_questions_text = '';
$question_count = count($cqResponse->result);

if ($question_count == 0) {
  $modx->setPlaceholder( 'has_custom_questions', "false" );
} else {

    
    //var_dump($cqResponse->result->custom_questions);
    $radioCQChunk = $modx->getOption( 'tpl', $scriptProperties, 'CustomQuestionRadio');
    $freeCQChunk = $modx->getOption( 'tpl', $scriptProperties, 'CustomQuestionFreeForm');
    $selectCQChunk = $modx->getOption( 'tpl', $scriptProperties, 'CustomQuestionSelect');
    for($j = 0; $j < $question_count; $j++) {
      $cq = $cqResponse->result[$j];

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
          $answer = '<input type="radio" name="custom_question_answers[ '.strval($cq->id).
          ' ]" value="'.$pa.'" id="'.$element_id.'"';
          
          $suffix = ' /><label for="'.$element_id.'">'.$pa.'</label>';
          $answers .= $answer.$suffix;
        }
        $custom_question_details['answer_options'] = $answers;

        $custom_question_text = $modx->getChunk($radioCQChunk, $custom_question_details);
        
      } else if ($cq->answer_type == "free_form") {
        // Free form
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

          $suffix = ' />'.$pa.'</option>';
          $answers .= $answer.$suffix;
        }
        $custom_question_details['answer_options'] = $answers;

        $custom_question_text = $modx->getChunk($selectCQChunk, $custom_question_details);
      }
      
      $custom_questions_text .= $custom_question_text;

    }
    $modx->setPlaceholder( 'custom_questions', $custom_questions_text );
    $modx->setPlaceholder( 'has_custom_questions', "true" );
}