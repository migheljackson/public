<?php
/**
 *
 *
 * @name fe_set_password_reset_parameters
 * @description sets the parameters for the password reset page
 *
 */

// parameters from form
$username= '"' . str_replace('%20', '', $_REQUEST["username"]) . '"';
$modx->setPlaceholder( 'username', $username);
$modx->setPlaceholder( 'forgotten_password_token', $_REQUEST["token"] );