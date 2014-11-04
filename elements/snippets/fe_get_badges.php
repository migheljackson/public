<?php
/**
 *
 *
 * @name fe_get_badges
 * @description
 *
 */

$core_path = $modx->getOption( 'col_public.core_path', '', MODX_CORE_PATH.'components/col_public/' );
require_once $core_path.'col-library/col.php';

$metaBadgesResults = COL::getMetaBadges();
// var_dump($metaBadgesResults);
$relatedTpl = $modx->getOption( 'tpl', $scriptProperties, 'BadgeCityItem' );
//echo "Search Results count: " . $allBadgesResults['hits']['total'] ;
$cityBadgeList = "";
foreach ($metaBadgesResults['hits']['hits'] as $badgeItem ) {
	$badge = $badgeItem['_source'];
	/*echo "<br/><br/>Badge" . $badge["name"] . " " . $badge["id"] . " " . $badge["image_url"] 
		. " " . $badge["blurb"];*/
	$cityBadgeList .= $modx->getChunk( $relatedTpl, $badge );
}

$modx->setPlaceholder("cityBadgeTotal", count($metaBadgesResults['hits']['hits']));
$modx->setPlaceholder("cityBadgeList", $cityBadgeList);

return;