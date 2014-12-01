<?php
/**
 *
 *
 * @name get-badge-city-details
 * @description
 *
 */

// parameters from form
$core_path = $modx->getOption( 'col_public.core_path', '', MODX_CORE_PATH.'components/col_public/' );
require_once $core_path.'col-library/col.php';
require_once $core_path.'col-library/col_user.php';

// COL::getAllBadges();
$badgeDetailsTpl = $modx->getOption( 'tpl', $scriptProperties, 'badgeCityDetails' );

// $badgeId = $id;
// $searchResults = COL::getBadgesById($badgeId);
// var_dump($searchResults);
// $badgeResult = $searchResults['hits']['hits'];
// var_dump($badgeResult[0]["_source"]);
$badge = $badgeResult[0]["_source"];
$badge_is_meta = false;
$badgeTypes = array("1"=>"organization", "2"=>"self-paced");

if ($badge["badge_type"] == "meta") {
	$badge_is_meta = true;
	$badge["badge_type"] = "City";
}

$seoTitle = $badge['name'];
$modx->setPlaceholder("dyn_page_title",$seoTitle);

if(count($badge["rule_sets"]) == 1) {
	$ruleset = $badge["rule_sets"][0];
	
	$badgeRequiredCount = 0;
	$ruleSetComplete = '<div class="panel small-12 columns">';
	$ruleComplete = "";
	$ruleCount = count($ruleset["rules"]);
	$classSize = floor(12/$ruleCount);
	$catIdList = array();
	foreach($ruleset["rules"] as $rule){
		// count total badges required all rules
		$badgeRequiredCount += $rule["number_badges"];
		
		// display each rule
		$ruleBadgeRequired=$rule["number_badges"];
		$ruleBadgeHtml = "<div class='small-". $classSize ." column'>";
		if(count($ruleset["rules"])>1) {
			$ruleBadgeHtml .= "<span class='counter'>".$ruleBadgeRequired . "</span> badges in:" ;
		}
		$rule_list_html = count($ruleset["rules"])==1 ? "<ul class='inline'>" : "<ul style='list-style:none;margin-left:0' >";		
		// rule based on category
		foreach($rule["from_categories"] as $category) {
			$rule_list_html .= '<li><p class="badge-title">' . $category["name"]  . '</p><a href="digital-badge-library?catId=' . $category['id'] . '">View badges</a></li>'; 
			$catIdList[] = $category['id'];
		}
		
		// rule based on type
		if($rule["of_type"] != 0) {
			$badgeType = $rule["of_type"];
			$rule_list_html .= '<li><p class="badge-title">' . $badgeTypes[$badgeType]  . '</p><a href="#">View badges</a></li>'; 
			// var_dump($category["name"]);
		}
		$rule_list_html .= "</ul>";
		//echo $rule_list_html;
		$ruleComplete .= $ruleBadgeHtml . $rule_list_html . "</div>";
	}
	$total = "<h6>Earn by collecting a total of <span class='counter'>" . $badgeRequiredCount . "</span> badges in:</h6>";
	$ruleSetComplete = $total . $ruleSetComplete . $ruleComplete . "</div>";	
}

// search for all programs

if(!empty($catIdList)) {
	$activities = COL::search("", $catIdList, 4, 100, null, array(), 0, 15, null, null, null, "ScheduledProgram,Pathway");
	// var_dump($activities);
	$activityTile = $modx->getOption( 'tpl', $scriptProperties, 'TileItem' );
	$activityHtml = "";
	foreach($activities["hits"]["hits"] as $activitySource) {
		// var_dump($activitySource["_source"]);
		$activity = $activitySource["_source"];
		$activityHtml .= $modx->getChunk($activityTile, $activity);
	}
	
}

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
						$evidenceHtml .= "<a target='_blank' href='". $full_evidence_url . "'>View Evidence Submission</a><br/>";
						$full_evidence_url = $site_url . "shared-challenge-badge?ibh=".$issued_badge_hash;
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
				if(!$badge_is_meta) {
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


$modx->setPlaceholders($badge);
$badge["totalBadgeRequirement"] = $totalBadgeRequirement;
$badge["ruleSetHtml"] = $ruleSetComplete;
$badge["activityHtml"] = $activityHtml;

// $modx->setPlaceholder("totalBadgeRequirement", $totalBadgeRequirement);
// $modx->setPlaceholder("ruleSetHtml", $ruleSetComplete);

$output = $modx->getChunk($badgeDetailsTpl, $badge);

return $output;
