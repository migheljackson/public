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
        $badge["informal_description"]
                = $badge["informal_description"]=="" ? $badge["description"] : $badge["informal_description"];
        $output = $modx->getChunk($badgeTpl, $badge);
        $badgeList .=$output;
}

$boilerPlate = '<div class="row"><div class="small-12 columns"><ul id="badge-library-list" class="small-block-grid-1 large-block-grid-4 columns">'. $badgeList . '</ul></div></div>';

$iTotalPages = intval( ceil( $allBadgesResults['hits']['total'] / 16 ) );
$paging = COL::build_pagination($modx, $iTotalPages, $pg);

$boilerPlate .= $paging;

return $boilerPlate;
