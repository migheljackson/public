<?php
/**
 *
 *
 * @name fe_do_badge_search
 * @description
 *
 */

$core_path = $modx->getOption( 'col_public.core_path', '', MODX_CORE_PATH.'components/col_public/' );
require_once $core_path.'col-library/col.php';

$pg = isset($_REQUEST["pg"]) ? $_REQUEST["pg"] : 0;
$catId = isset($_REQUEST["catId"]) ? $_REQUEST["catId"] : 0;
$allBadgesResults = COL::getAllBadges($pg, $catId);

/* construct other badges */
$badgeTpl = $modx->getOption( 'tpl', $scriptProperties, 'BadgeItem' );
$badgeList = "";

foreach ($allBadgesResults['hits']['hits'] as $badgeItem) {
	$badge = $badgeItem['_source'];
	$activity_html="";
	if(count($badge["activities"]) > 0) {
		$counter==1;
		$activity_label = count($badge["activities"]) > 1 ? "DO THESE ACTIVITIES" : "DO THIS ACTIVITY";
		$activity_html = '<h6>'.$activity_label.'</h6><div style="height:51px;overflow:hidden;">';
		foreach($badge["activities"] as $activity) {

			// build link based on type ScheduledProgram vs Pathway
			$link = $activity["activity_type"]=="ScheduledProgram" ? "workshop-detail?ref=bad-lib&id=" : "challenges?ref=bad-lib&id=";
			$activity_html .= '<a href="' . $link . $activity["id"] . '"><img style="height:48px;margin-right:1px" src="'.$activity["logo_url"].'" title="' . $activity["name"] .'"/></a>';
			if($counter++>3) break;
		}
		$activity_html .="</div>";
	}
	$badge["informal_description"]
	= $badge["informal_description"]=="" ? $badge["description"] : $badge["informal_description"];
	if($badge["informal_description"].length>160) {
		$badge["informal_description"] = substr($badge['informal_description'],0,160)."...";
	}
	$badge["activity_list"] = $activity_html;
	$output = $modx->getChunk($badgeTpl, $badge);
	$badgeList .=$output;
}

$boilerPlate = '<div class="row"><div class="small-12 columns"><ul id="badge-library-list" class="small-block-grid-1 large-block-grid-4 columns">'. $badgeList . '</ul></div></div>';

$iTotalPages = intval( ceil( $allBadgesResults['hits']['total'] / 16 ) );
$paging = COL::build_pagination($modx, $iTotalPages, $pg);

$boilerPlate .= $paging;

return $boilerPlate;
