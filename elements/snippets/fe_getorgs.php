<?php
/**
 * @name fe_getorgs
 * @description 
 *
 */

$core_path = $modx->getOption( 'col_public.core_path', '', MODX_CORE_PATH.'components/col_public/' );
require_once $core_path.'col-library/col.php';

$org_result = COL::get_orgs();

$orgs_json = json_decode(json_encode($org_result), true);

$orgs = $orgs_json["result"];

$orgHtml = "";
// print_r($orgs);
foreach($orgs as $org) {
	// print_r($org);
	// validate logo url
	// validate url
	$orgHtml .= '<div class="col-md-3 logo-box"><a title="' . $org["name"] . '" href="' . $org["url"] . '"><img style="height: 75px;" src="'. $org["logo_url"] .'" alt="' . $org["url"] . '" onerror="loadtitle();"/></a></div>';
	// $orgHtml.="<li><a href='". $org["url"] . "'><img src='" . $org["logo_url"] . "' title='" . $org["name"] . "'/></a></li>";	
}

$modx->setPlaceholder("orgs",$orgHtml);
return;
// return $orgHtml;
