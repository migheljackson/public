<?php
/**
 *
 *
 * @name fe_get_securityquestions
 * @description
 *
 */

// parameters from form
$core_path = $modx->getOption( 'col_public.core_path', '', MODX_CORE_PATH.'components/col_public/' );
require_once $core_path.'col-library/col.php';

$response = COL::system_get('/security_questions.json');

$qChunk = $modx->getOption( 'tpl', $scriptProperties, 'SecurityQuestion' );
$aiChunk = $modx->getOption( 'tpl', $scriptProperties, 'SecurityAnswerImage' );
$atChunk = $modx->getOption( 'tpl', $scriptProperties, 'SecurityAnswerText' );

$question_output = "";
for ($i = 0; $i < count($response->result); $i++) {
  $question = $response->result[$i];
  
  $answers_output = "";
  for ($j = 0; $j < count($question->security_question_answers); $j++) {

    $answer = $question->security_question_answers[$j]->security_question_answer;
    $answer_data = array('security_question_id' => $question->id, 'image_url' => $answer->image_url, 'answer_id' => $answer->id, 'answer' => $answer->answer);
    if (strlen($answer->image_url) > 0) {
      $answers_output .= $modx->getChunk( $aiChunk, $answer_data);
    } else {
      $answers_output .= $modx->getChunk( $atChunk, $answer_data);
    }

  }
  
  $question_output .= $modx->getChunk( $qChunk, array('question' => $question->question, 'answers' => $answers_output));
}

$modx->setPlaceholder( 'security_questions', $question_output );