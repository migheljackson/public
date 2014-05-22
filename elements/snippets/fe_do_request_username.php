<?php
/**
 *
 *
 * @name fe_do_request_username
 * @description
 *
 */

// parameters from form
$core_path = $modx->getOption( 'col_public.core_path', '', MODX_CORE_PATH.'components/col_public/' );
require_once $core_path.'col-library/col.php';

$user = array( 'user' => $_REQUEST );

if ( isset( $_REQUEST["security_question"] ) ) {

  $security_answers = $_REQUEST["security_question"];


  // parse out the security_questions and build up object
  $user_security_answers = array();

  foreach ( $security_answers as $question_id => $answer_id ) {
    array_push( $user_security_answers, array( 'security_question_id' => trim( $question_id ), 'security_question_answer_id' => trim( $answer_id ) ) );
  }

  $user['user']['security_answers'] = $user_security_answers;

}


$response = COL::post('/users/request_username.json', $user);
//var_dump($response);
if(isset($response->result->security_questions)) {
  $qChunk = $modx->getOption( 'tpl', $scriptProperties, 'SecurityQuestion' );
  $aiChunk = $modx->getOption( 'tpl', $scriptProperties, 'SecurityAnswerImage' );
  $atChunk = $modx->getOption( 'tpl', $scriptProperties, 'SecurityAnswerText' );
  $question_output = "";
  for ($i = 0; $i < count($response->result->security_questions); $i++) {
    $question = $response->result->security_questions[$i];
    
    $answers_output = "";
    for ($j = 0; $j < count($question->security_question_answers); $j++) {

      $answer = $question->security_question_answers[$j];
      $answer_data = array('security_question_id' => $question->id, 'image_url' => $answer->image_url, 'answer_id' => $answer->id, 'answer' => $answer->answer);
      if (strlen($answer->image_url) > 0) {
        $answers_output .= $modx->getChunk( $aiChunk, $answer_data);
      } else {
        $answers_output .= $modx->getChunk( $atChunk, $answer_data);
      }

    }
    
    $question_output .= $modx->getChunk( $qChunk, array('question' => $question->question, 'answers' => $answers_output));
  }
  $response->result->security_question_html = $question_output;
}


return JWT::jsonEncode( $response );