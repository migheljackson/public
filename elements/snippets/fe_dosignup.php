<?php
/**
 *
 *
 * @name fe_dosignup
 * @description takes form from signup and returns json results
 *
 */

$core_path = $modx->getOption( 'col_public.core_path', '', MODX_CORE_PATH.'components/col_public/' );
require_once $core_path.'col-library/col.php';

// take form values and build up object
$user = array( 'user' => $_REQUEST );
//var_dump($_REQUEST);
$security_answers = $_REQUEST["security_question"];


// parse out the security_questions and build up object
$user_security_answers = array();

foreach ( $security_answers as $question_id => $answer_id ) {
  array_push( $user_security_answers, array( 'security_question_id' => trim($question_id), 'security_question_answer_id' => trim($answer_id) ) );
}

$user['user']['security_answers'] = $user_security_answers;
//var_dump($user_security_answers);

// call the COL Engine
$response = COL::post_encrypted_json( '/users/signup.json', $user );

$parsed_response = JWT::jsonDecode($response);

if($parsed_response->status == 200 || $parsed_response->status == 201) {
  setcookie(COL::COOKIE_NAME_AU, JWT::encode($parsed_response->result, COL::KEY), time()+COL::SESSION_TIME );
}


return $response;