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

$badge = $badgeResult[0]["_source"];
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

// $modx->setPlaceholders($badge);
//get user if available
if (isset($badge["issued_badges"])) {
	if($badge["issued_badges"]) {
		foreach($badge["issued_badges"] as $ibadge) {
			if(empty($issueDateHtml)) {	
				$date = new DateTime($ibadge["awarded_at"]);
				$issueDateHtml='<h5 class="text-center"><strong>Date issued:</strong></h5><p class="text-center">'.$date->format('m/d/Y').'</p>';
				$modx->setPlaceholder("issuedate",$issueDateHtml);
				$badge["issuedate"] = $issueDateHtml;
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
				$badge["evidence"] = $evidenceHtml;
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
	$badge["issuer"] = $issuer_output;
	$seoTitle = $badge['name'] . " by " . $org['name'];
	$modx->setPlaceholder("dyn_page_title",$seoTitle);

	$criteria = $badge["badge_criteria"];
	if(isset($criteria)) {
		$output = "<p style=\"margin-bottom:.1em\"><strong>Critera</strong></p><ol>";
		foreach($criteria as $item) {
			$output.="<li>";
			if($item["required"]==true){
				$output.="[required] ";
			}
			$output.= $item["description"]."</li>";
		}
		$output.="</ol>";
		$modx->setPlaceholder("criteria", $output);
		$badge["criteria"] = $output;
	}

	$duration = "<p><strong>Expected Duration:</strong> ".$badge["duration"]."</p>";
	$modx->setPlaceholder("duration", $duration);
	$badge["duration"] = $duration;
} else {
	$seoTitle = $badge['name'];
        $modx->setPlaceholder("dyn_page_title",$seoTitle);
}

// load activities
if(count($badge["activities"])>0) {
	$badgeActivity = $modx->getOption( 'tpl', $scriptProperties, 'BadgeActivity');
	
	$activityHtml = "<p><strong>Earn by participating in:</strong></p>";
	$today = new DateTime("now");
	 
	foreach($badge["activities"] as $activity) {
		$programDate = new DateTime($activity["end_date"]);
		if(isset($activity["end_date"]) && $activity["end_date"]!="" ) {
			$activity["expiredProgram"] = $programDate < $today ? "" : "style='display:none'";
			$activity["activeProgram"] = $programDate > $today ? "" : "style='display:none'";
		} else{
			$activity["expiredProgram"] = "style='display:none'";
			$activity["activeProgram"]  = "";
		}
		$activityHtml .=  $modx->getChunk($badgeActivity, $activity);
	}
	$modx->setPlaceholder("activityList", $activityHtml);
	$badge["activityList"] = $activityHtml;
}

// load related badges
//build cat list
$catList = array();
foreach($badge["categories"] as $category) {
	$catList[$category["id"]] = $category["id"];
}

$relatedBadgesResults = COL::getBadgesByCategories($catList);

/* construct other badges */
$badgeTpl = $modx->getOption( 'tpl', $scriptProperties, 'BadgeItem' );
$badgeList = "";
foreach ($relatedBadgesResults['hits']['hits'] as $badgeItem) {
	// var_dump($badgeItem);
	$relatedBadge = $badgeItem['_source'];
	$relatedBadge["informal_description"]
	= $relatedBadge["informal_description"]=="" ? $relatedBadge["description"] : $relatedBadge["informal_description"];
	$output = $modx->getChunk($badgeTpl, $relatedBadge);
	$badgeList .=$output;
}

$badge["badgeList"] = $badgeList;

$badgeDetailsTpl = $modx->getOption( 'tpl', $scriptProperties, 'badgeDetails' );
$output = $modx->getChunk($badgeDetailsTpl, $badge);
return $output;
