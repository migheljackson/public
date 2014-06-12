<?php

/**
 *
 *
 * @name get-badge-details
 * @description
 *
 */

// parameters from form
$core_path = $modx->getOption( 'col_public.core_path', '', MODX_CORE_PATH.'components/col_public/' );
require_once $core_path.'col-library/col.php';

$badgeId = $_GET["id"];
$badgeMeta = COL::get_badge($badgeId);
// $modx->setPlaceholder("badge",$badgeMeta);
$badgeMeta = json_decode(json_encode($badgeMeta), true);
$badge = $badgeMeta['result'];

$modx->setPlaceholders($badge);



$orgEndpoint = "/orgs/".strval($badge['org_id']).".json";

$org = COL::get($orgEndpoint);
$org = json_decode(json_encode($org), true);
// print_r($org["result"]);
$modx->setPlaceholders($org["result"],"org.");

$criteria = $badge["badge_criteria"];
if(isset($criteria)) {
	$output = "<p class=\"text-center\" style=\"margin-bottom: 0px;text-decoration:underline\">Critera</p><ul class=\"text-center\" style=\"list-style:none\">";
	foreach($criteria as $item) {
		$output.="<li>";
		if($item["badge_criterium"]["required"]==true){
			$output.="[required] ";
		}
		$output.= $item["badge_criterium"]["description"]."</li>";
	}
	$output.="</ul>";
	$modx->setPlaceholder("criteria", $output);
}
return;