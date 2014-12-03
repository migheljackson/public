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

$extra_options = array( );

$extra_options['extra_option'] = '<label for="opt1"> <input type="checkbox" name="reasons[]" value="I do not allow my child to have accounts of their own." id="opt1" style="visibility:visible"> I do not allow my child to have accounts of their own. </label>';
$extra_options['form_title'] = 'Delete my child’s account.';
$extra_options['yes_label'] = 'Yes, delete their account.';
$extra_options['no_label'] = 'No, I want my child to keep their account.';
$extra_options['reasons_title'] = 'Optional: You want to delete their account because:';
$extra_options['origin'] = 'parent';

if (isset($_REQUEST['user_originated'])) {
  $extra_options['form_title'] = 'Delete my account.';
  $extra_options['yes_label'] = 'Yes, delete my account.';
  $extra_options['no_label'] = 'No, I want keep my account.';
  $extra_options['reasons_title'] = 'Optional: You want to delete your account because:';
  $extra_options['extra_option'] = '';
  $extra_options['origin'] = 'user';
}

$modx->setPlaceholders($extra_options);