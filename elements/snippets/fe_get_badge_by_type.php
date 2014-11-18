<?php
/**
 *
 *
 * @name fe_get_badge_by_type
 * @description
 *
 */

// parameters from form
$core_path = $modx->getOption( 'col_public.core_path', '', MODX_CORE_PATH.'components/col_public/' );
require_once $core_path.'col-library/col.php';

$badgeId = $_REQUEST["id"];
$searchResults = COL::getBadgesById($badgeId);
$badgeResult = $searchResults['hits']['hits'];
// var_dump($badgeResult);
// fork to city badge view or to challenge/org badge view
$badge = $badgeResult[0]["_source"];
if ($badge["badge_type"] == "meta") {
	$badge["badge_type"] = "City";
	$badgeDetails = $modx->runSnippet("get-badge-city-details", array("badgeResult" => $badgeResult));
} else {
	$badgeDetails = $modx->runSnippet("get-badge-details", array("badgeResult" => $badgeResult));
}


return $badgeDetails;