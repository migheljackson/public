<?php
/**
 *
 *
 * @name fe_set_password_reset_parameters
 * @description sets the parameters for the password reset page
 *
 */

// parameters from form

$modx->setPlaceholder( 'username', $_REQUEST["username"] );
$modx->setPlaceholder( 'forgotten_password_token', $_REQUEST["token"] );