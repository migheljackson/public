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
$sbadge = null;
// check if a user is logged in
if(COL::is_signed_in()) {

	$badgeMeta = COL::get_badge($_REQUEST["id"]);
	$badgeMeta = json_decode(json_encode($badgeMeta), true);
	$sbadge = $badgeMeta['result'];
	
	if (isset($sbadge["issued_badges"])) {
		
		$show_issued_badges = true;
	}
}	
  // if so get the badge, which should return their issued badges

// $modx->setPlaceholders($badge);
//get user if available
//var_dump($show_issued_badges);
if  ($show_issued_badges) {
	$user_is_over_13 = COL::_get_is_over_13();
	
	$issueDateHtml = '';
	$site_url = $modx->getOption('site_url');
	$site_name = $modx->getOption('site_name');
	//var_dump($sbadge);
	if($sbadge["issued_badges"]) {
		$evidence_url = "";
		foreach($sbadge["issued_badges"] as $ibadge) {
			
			$issued_badge_hash = $ibadge["shared_badge_hash"];
			if(empty($issueDateHtml)) {	
				$date = new DateTime($ibadge["awarded_at"]);
				$issueDateHtml='<p class=""><strong>Date issued:</strong> '.$date->format('m/d/Y').'</p>';
				$modx->setPlaceholder("issuedate",$issueDateHtml);
				$badge["issuedate"] = $issueDateHtml;
				
			}
			if(!empty($ibadge["evidences"])) {
				$evidenceHtml ="<strong>Evidence:</strong><p class=''>";
				if ($badge_is_challenge) {
						$evidence_url = $ibadge["evidences"][0]["url"];
						$full_evidence_url = $site_url . "shared-challenge-badge?ibh=".$issued_badge_hash;
						$evidenceHtml .= "<a target='_blank' href='". $full_evidence_url . "'>View Evidence Submission</a><br/>";
						
				}
				else if (!$badge_is_meta) {
					foreach($ibadge["evidences"] as $evidence) {
						$evidenceHtml .= "<a href='". $evidence["url"] . "'>View Evidence Submission</a><br/>";
						$evidence_url = $evidence["url"];
						
					}
					
					$full_evidence_url = $site_url . "shared-org-badge?ibh=".$issued_badge_hash;
				} else {
					foreach($ibadge["evidences"] as $evidence) {
						$evidenceHtml .= "<a href='/badge-details?id=".$evidence["awarded_badge_id"]."'><img src='". $evidence["url"] . "' class='badge-mini'/></a>";
					}

					$full_evidence_url = $site_url . "shared-city-badge?ibh=".$issued_badge_hash;
				}

				$modx->setPlaceholder("evidence",$evidenceHtml);
				$badge["evidence"] = $evidenceHtml;
			} {
				if ($badge_is_challenge) {
					$full_evidence_url = $site_url . "shared-challenge-badge?ibh=".$issued_badge_hash;
				} else if(!$badge_is_meta) {
					$full_evidence_url = $site_url . "shared-org-badge?ibh=".$issued_badge_hash;
				} else {

				}	$full_evidence_url = $site_url . "shared-city-badge?ibh=".$issued_badge_hash;
			}
		}
		 // leaving these out of the condition to handle the other types of badges to share
		$share_options = array("share_label" => "Share your badge");
		$share_options['share_url'] = $full_evidence_url;
		$share_options["facebook_title"] = "I earned the ".$sbadge["name"]." badge";
		$share_options["facebook_content"] = "I earned the ".$sbadge["name"]." badge through @ChicagoCityofLearning. #CCOL connects me with fun programs around the city and online activities that let me explore my interest. It’s just for youth and you can join CCOL for free.";
		$share_options["twitter_content"] = "I earned a digital badge through #CCOL. Join CCOL now and @ExploreChi with me! #myccolbadge";
		$share_options["pinterest_content"] = "I earned the ".$sbadge["name"]." badge through ChicagoCityofLearning (CCOL). #CCOL connects me with fun programs around the city and online activities that let me explore my interest. It’s just for youth and you can join CCOL for free. #myccolbadge through #CCOL. See what I learned - and @ExploreChi with me! Join CCOL now so you can learn and earn. #myccolbadge";
		$share_options["tumbler_content"] = "I earned the ".$sbadge["name"]." badge through ChicagoCityofLearning (CCOL). I get connected to fun things to do that let me explore my interest. It’s just for youth and you can join CCOL for free. ";
		$share_options["linkedin_content"] = "I earned the ".$sbadge["name"]." badge through Chicago City of Learning (CCOL).  I earn digital badges when I complete in person programs around the city or online activities.";
		$share_options["email_content"] = " Hi! Check out the ".$sbadge["name"]." badge I earned through Chicago City of Learning. I wanted to share it with you so you can see what I’ve been up to. At <a href='https://www.ChicagoCityofLearning.org'>www.ChicagoCityofLearning.org</a> I can find online activities and programs around the city that let me explore my interest. After I learn something cool, I earn a digital badge that shows my achievement and what I did to earn it. through ChicagoCityofLearning(CCOL). #CCOL connects me with fun programs around the city and online activities that let me explore my interest. It’s just for youth and you can join CCOL for free. #myccolbadge through #CCOL. See what I learned - and @ExploreChi with me! Join CCOL now so you can learn and earn. #myccolbadge";
		$share_options["email_title"] = " Hi! Check out the ".$sbadge["name"]." badge I earned through Chicago City of Learning.";
		$share_options["image_url"] = $sbadge["image_url"];

		if($user_is_over_13) {
			if ( $badge_is_challenge ) {
				  //$site_url . "shared-challenge-badge?h=".."&b=".$_REQUEST["id"]."&e=" . urlencode($evidence_url);

			} else if($badge_is_meta) {
				$share_options['share_url'] = $full_evidence_url;
			} else {
				$share_options['share_url'] = $full_evidence_url;
			}	

			$sbChunk = $modx->getOption( 'tpl', $scriptProperties, 'ShareButtons' );
			$share_buttons =  $modx->getChunk($sbChunk, $share_options);

			$page_sub_header = '<div class="small-12 left playlists"><h5>'.$share_buttons.'</h5></div>'; 
		
		} else {
			$page_sub_header =  '';//'<div class="small-12 left playlists"><h5>'.$sbadge["name"].'</h5></div>';
		}
		$share_options["page_title"] = $sbadge["name"];
		$share_options["page_url"] = $share_options["share_url"];
		$share_options["page_image_url"] = $share_options["image_url"];
		$share_options["page_description"] = $badge["description"];
		$share_options["site_name"] = $site_name;

		$ogmtChunk = $modx->getOption( 'tpl', $scriptProperties, 'OpenGraphMetaTags' );
		$ogmt_content=  $modx->getChunk($ogmtChunk, $share_options);
		$modx->regClientStartupHTMLBlock($ogmt_content);
	}	
	
}

if (!$badge_is_meta && !$badge_is_challenge) {
	$orgEndpoint = "/orgs/".strval($badge['org_id']).".json";

	$org = COL::get($orgEndpoint);
	$org = json_decode(json_encode($org), true);
	$org = $org["result"];
	$issuer_output = '<p><strong>Issuer:</strong></p><img src="'.$org["logo_url"].'" style="max-height:50px" class="left"/> <p class="text-center">'.$org["name"].
'<br/><a target="_blank" href="'.$org["url"].'" title="'.$org["description"].'">'.$org["url"].'</a></p>';
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
		if($activity["activity_type"]=="Pathway") {
			
			$activity["link"] = "challenges?id=" . substr($activity["id"],8);
		} else {
			$activity["link"] = "workshop-detail?id=" . $activity["id"];
		}
		$activityHtml .=  $modx->getChunk($badgeActivity, $activity);
		//var_dump($activity);
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