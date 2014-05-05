<?php
/**
 *
 *
 * @name fe_do_request_reset_password
 * @description takes username or email from forgotten password page, and either returns email message or form to do password reset
 *
 */

$core_path = $modx->getOption( 'col_public.core_path', '', MODX_CORE_PATH.'components/col_public/' );
require_once $core_path.'col-library/col.php';

$username = $_REQUEST["username"];

// take the username or password and post to engine
$response = COL::post_encrypted( "/users/request_password_reset.json", array( 'user' => array( 'username' => $username ) ) );
//var_dump($response);
$mChunk = $modx->getOption( 'tpl', $scriptProperties, 'RequestPasswordResetMessage' );
// if 404
if ( $response->status == 404 ) {
  // set message The username or email address is not associated with an account
  $main_message = "The username or email address is not associated with an account";

  return $modx->getChunk($mChunk,  array('main_message' => $main_message ));
} else {
  // if user is over 13
// take obfuscated email address and render message template
  if ( $response->result->user_over_13  ) {
    $main_message = "A password reset link will be sent to: ".$response->result->email_address;
    return $modx->getChunk($mChunk,  array('main_message' => $main_message, 'link_url' => 'explore', 'link_message' => 'Keep exploring' ));

  } else {
    // create security question templates
    $pageChunk = $modx->getOption( 'tpl', $scriptProperties, 'Under13ResetPassword' );
    $qChunk = $modx->getOption( 'tpl', $scriptProperties, 'SecurityQuestion' );
    $aiChunk = $modx->getOption( 'tpl', $scriptProperties, 'SecurityAnswerImage' );
    $atChunk = $modx->getOption( 'tpl', $scriptProperties, 'SecurityAnswerText' );


    $question_output = "";
    for ( $i = 0; $i < count( $response->result->security_questions ); $i++ ) {
      $question = $response->result->security_questions[$i];

      $answers_output = "";
      for ( $j = 0; $j < count( $question->security_question_answers ); $j++ ) {

        $answer = $question->security_question_answers[$j];
        $answer_data = array( 'security_question_id' => $question->id, 'image_url' => $answer->image_url, 'answer_id' => $answer->id, 'answer' => $answer->answer );
        //var_dump( $answer);
        if ( strlen( $answer->image_url) > 0 ) {
          $answers_output .= $modx->getChunk( $aiChunk, $answer_data );
        } else {
          $answers_output .= $modx->getChunk( $atChunk, $answer_data );
        }

      }

      $question_output .= $modx->getChunk( $qChunk, array( 'question' => $question->question, 'answers' => $answers_output ) );
    }
    // render reset_password page
    return $modx->getChunk($pageChunk, array('username' => $username, 'security_questions' => $question_output ));
  }
}