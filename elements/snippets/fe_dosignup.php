<?php
/**
 *
 *
 * @name fe_dosignup
 * @description takes form from signup and returns json results
 *
 */

// take form values and build up object 

// parse out the security_questions and build up object

$user = array('user' => $_POST);

$security_answers = $_POST["security_questions"];

$user_security_answers = array();

var_dump($security_answers);