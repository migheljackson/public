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

$catId = isset($_REQUEST["catId"]) ? $_REQUEST["catId"] : 0;
$allBadgesResults = COL::getAllBadges(0, $catId);
// $allBadgesResults = COL::getAllBadges();
$categoriesData = COL::list_categories();

$categories = $categoriesData->result;

$categorySelect = "<select id='categoryFilter' class='drop-item small-3 columns end'><option id='0'>Filter By Category</option>";
foreach($categories as $category) {
	$selected = $category->id == $catId ? "selected" : "";
	$categorySelect .="<option ". $selected ." value='" . $category->id . "'>" . $category->name . "</option>";			
}
$categorySelect .= "</select>";

$modx->setPlaceholder("categorySelect", $categorySelect);

/* construct meta badges */
$relatedTpl = $modx->getOption( 'tpl', $scriptProperties, 'BadgeCityItem' );
$cityBadgeList = "";
foreach ($metaBadgesResults['hits']['hits'] as $badgeItem ) {
        $badge = $badgeItem['_source'];
        $badge["blurb"] = substr($badge['blurb'],0,80) . "...";
        $cityBadgeList .= $modx->getChunk( $relatedTpl, $badge );
}

$modx->setPlaceholder("cityBadgeTotal", $metaBadgesResults['hits']['total']);
$modx->setPlaceholder("cityBadgeList", $cityBadgeList);

/* construct other badges */
$badgeTpl = $modx->getOption( 'tpl', $scriptProperties, 'BadgeItem' );
$badgeList = "";
foreach ($allBadgesResults['hits']['hits'] as $badgeItem) {
        $badge = $badgeItem['_source'];
        $badge["informal_description"]
                = $badge["informal_description"]=="" ? $badge["description"] : $badge["informal_description"];
        $output = $modx->getChunk($badgeTpl, $badge);
        $badgeList .=$output;
}

$modx->setPlaceholder("badgeTotal", $allBadgesResults['hits']['total']);
$modx->setPlaceholder("badgeList", $badgeList);

$iTotalPages = intval( ceil( $allBadgesResults['hits']['total'] / 16 ) );
$paging = COL::build_pagination($modx, $iTotalPages);

$modx->setPlaceholder("paging", $paging);

return;