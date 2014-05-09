<?php
/**
 *
 *
 * @name fe_get_account_remove_params
 * @description takes all the parameters passed to it, and sets placeholders
 *
 */

$modx->setPlaceholder('username', $_REQUEST["username"]);
$modx->setPlaceholder('veto_token', $_REQUEST["token"]);