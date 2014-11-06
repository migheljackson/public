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
$allBadgesResults = COL::getAllBadges();

/* construct meta badges */
$relatedTpl = $modx->getOption( 'tpl', $scriptProperties, 'BadgeCityItem' );
$cityBadgeList = "";
foreach ($metaBadgesResults['hits']['hits'] as $badgeItem ) {
        $badge = $badgeItem['_source'];
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

$iTotalPages = intval( ceil( $allBadgesResults['hits']['total'] / 12 ) );
$paging = COL::build_pagination($modx, $iTotalPages);

$modx->setPlaceholder("paging", $paging);

return;