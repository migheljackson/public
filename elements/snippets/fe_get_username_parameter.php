<?php
/**
 *
 *
 * @name fe_get_username_parameter
 * @description takes username from request parameters and sets a placeholder if it exists
 *
 */

 if(isset($_REQUEST['username'])) {
  $modx->setPlaceholder('username', $_REQUEST['username']);
 }