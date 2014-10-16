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
require_once $core_path.'col-library/col_user.php';

$badgeId = $_GET["id"];
$badgeMeta = COL::get_badge($badgeId);
// $modx->setPlaceholder("badge",$badgeMeta);
$badgeMeta = json_decode(json_encode($badgeMeta), true);
$badge = $badgeMeta['result'];
$badge_is_meta = false;

if ($badge["badge_type"] == "meta") {
	$badge_is_meta = true;
	$badge["badge_type"] = "City";
}

$badge_is_challenge = false;

if ($badge["badge_type"] == "challenge") {
	$badge_is_challenge = true;
	$badge["badge_type"] = "Challenge";
}

$modx->setPlaceholders($badge);
//get user if available
if (isset($badge["issued_badges"])) {
	if($badge["issued_badges"]) {
		foreach($badge["issued_badges"] as $ibadge) {
			if(empty($issueDateHtml)) {	
				$date = new DateTime($ibadge["awarded_at"]);
				$issueDateHtml='<h5 class="text-center"><strong>Date issued:</strong></h5><p class="text-center">'.$date->format('m/d/Y').'</p>';
				$modx->setPlaceholder("issuedate",$issueDateHtml);
			}
			if(!empty($ibadge["evidences"])) {
				$evidenceHtml ="<h5 class='text-center'><strong>Evidence:</strong></h5><p class='text-center'>";
				if (!$badge_is_meta) {
					foreach($ibadge["evidences"] as $evidence) {
						$evidenceHtml .= "<a href='". $evidence["url"] . "'>" . $evidence["url"] . "</a><br/>";
					}
				} else {
					foreach($ibadge["evidences"] as $evidence) {
						$evidenceHtml .= "<a href='/badge-details?id=".$evidence["awarded_badge_id"]."'><img src='". $evidence["url"] . "' class='badge-mini'/></a>";
					}
				}

				$modx->setPlaceholder("evidence",$evidenceHtml);
			}
		}
	}
	
}

if (!$badge_is_meta && !$badge_is_challenge) {
	$orgEndpoint = "/orgs/".strval($badge['org_id']).".json";

	$org = COL::get($orgEndpoint);
	$org = json_decode(json_encode($org), true);
	$org = $org["result"];
	$issuer_output = '<h5 class="text-center"><strong>Issuer:</strong></h5><img src="'.$org["logo_url"].'" style="max-height:50px" class="left"/> <p class="text-center">'.$org["name"].
'<br/><a href="'.$org["url"].'" title="'.$org["description"].'">'.$org["url"].'</a></p>';
	$modx->setPlaceholder("issuer", $issuer_output);


	$criteria = $badge["badge_criteria"];
	if(isset($criteria)) {
		$output = "<p class=\"text-center\" style=\"margin-bottom: 0px;\"><strong>Critera</strong></p><ul class=\"text-center\" style=\"list-style:none\">";
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

	$duration = "<p class='text-center'><strong>Expected Duration:</strong> ".$badge["duration"]."</p>";
	$modx->setPlaceholder("duration", $duration);
}

$seoTitle = $workshop['name'] . " by " . $workshop['issuer'];
$modx->setPlaceholder("dyn_page_title",$seoTitle);

return;