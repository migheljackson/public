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
	$ruleCount = count($ruleset["rules"]); // four rules to each container
	$classSize = $ruleCount<5 ? floor(12/$ruleCount) : 3;
	$catIdList = array();
	foreach($ruleset["rules"] as $rule){
		// count total badges required all rules
		$badgeRequiredCount += $rule["number_badges"];
		
		
		// display each rule
		$ruleBadgeRequired=$rule["number_badges"];
		$ruleBadgeHtml = "<div class='rule small-". $classSize ." column' >";
		if(count($ruleset["rules"])>1) {
			$ruleBadgeHtml .= "<span class='counter'>".$ruleBadgeRequired . "</span> badges in:" ;
		}
		$rule_list_html = count($ruleset["rules"])==1 ? "<ul class='inline'>" : "<ul style='list-style:none;margin-left:0' >";		
		// rule based on category
		foreach($rule["from_categories"] as $category) {
			$rule_list_html .= '<li class="rule-box"><p class="badge-title">' . $category["name"]  . '</p><a class="rule-link" href="digital-badge-library?catId=' . $category['id'] . '">View badges</a></li>'; 
			$catIdList[] = $category['id'];
		}
		
		// rule based on type
		if($rule["of_type"] != 0) {
			$badgeType = $rule["of_type"];
			$link = $badgeTypes[$badgeType]=="self-paced" ? "Pathway" : "ScheduledProgram";
			$rule_list_html .= '<li class="rule-box"><p class="badge-title">' . $badgeTypes[$badgeType]  . '</p><a class="rule-link" href="explore/?result_type=' . $link . '">View badges</a></li>'; 
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

$modx->setPlaceholders($badge);
$badge["totalBadgeRequirement"] = $totalBadgeRequirement;
$badge["ruleSetHtml"] = $ruleSetComplete;
$badge["activityHtml"] = $activityHtml;

// $modx->setPlaceholder("totalBadgeRequirement", $totalBadgeRequirement);
// $modx->setPlaceholder("ruleSetHtml", $ruleSetComplete);

$output = $modx->getChunk($badgeDetailsTpl, $badge);

return $output;
