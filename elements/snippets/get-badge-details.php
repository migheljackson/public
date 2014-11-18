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

$page_sub_header = '<div class="small-12 left playlists"><h3><strong>EXPLORE</strong></h3></div>';

$show_issued_badges = false;
// check if a user is logged in
if(COL::is_signed_in()) {

	$badgeMeta = COL::get_badge($badge["id"]);
	$badgeMeta = json_decode(json_encode($badgeMeta), true);
	$sbadge = $badgeMeta['result'];
	
	if (isset($sbadge["issued_badges"])) {
		
		$show_issued_badges = true;
	}
}	
  // if so get the badge, which should return their issued badges

// $modx->setPlaceholders($badge);
//get user if available
if ($show_issued_badges) {
	$user_is_over_13 = COL::_get_is_over_13();
	
	$issueDateHtml = '';
	if ($user_is_over_13) {
		$page_sub_header = '<div class="small-12 left playlists"><h5> <!-- AddToAny BEGIN --> <div id="share_buttons" class="a2a_kit a2a_kit_size_32 a2a_default_style" style="margin: 0 auto;width: 400px;"> <p style="float: left;">Share your badge</p>  <a class="a2a_button_facebook"></a> <a class="a2a_button_twitter"></a> <a class="a2a_button_google_plus"></a> <a class="a2a_button_pinterest"></a> <a class="a2a_button_myspace"></a> <a class="a2a_button_tumblr"></a> <a class="a2a_button_email"></a> </div> <script type="text/javascript" src="//static.addtoany.com/menu/page.js"></script> <!-- AddToAny END --></h5></div>'; 
		
	} else {
		$page_sub_header = '<div class="small-12 left playlists"><h5>'.$sbadge["name"].'</h5></div>';
	}
	if($sbadge["issued_badges"]) {

		foreach($sbadge["issued_badges"] as $ibadge) {
			if(empty($issueDateHtml)) {	
				$date = new DateTime($ibadge["awarded_at"]);
				$issueDateHtml='<p class=""><strong>Date issued:</strong> '.$date->format('m/d/Y').'</p>';
				$modx->setPlaceholder("issuedate",$issueDateHtml);
				$badge["issuedate"] = $issueDateHtml;
				
			}
			if(!empty($ibadge["evidences"])) {
				$evidenceHtml ="<strong>Evidence:</strong><p class=''>";
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
	$issuer_output = '<p><strong>Issuer:</strong></p><img src="'.$org["logo_url"].'" style="max-height:50px" class="left"/> <p class="text-center">'.$org["name"].
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
$modx->setPlaceholder("page_sub_header",$page_sub_header);

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

$badgeDetailsTpl = $modx->getOption( 'tpl', $scriptProperties, 'BadgeDetails' );
//var_dump($badge);
$output = $modx->getChunk($badgeDetailsTpl, $badge);
return $output;