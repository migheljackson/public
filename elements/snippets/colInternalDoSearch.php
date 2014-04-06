<?php
/**
 * @name colInternalDoSearch
 * @description This snippet does the search with all the parameters
 *
 */

  $core_path = $modx->getOption('col_public.core_path','',MODX_CORE_PATH.'components/col_public/');
require_once $core_path.'col-library/col.php';
  if (isset($_REQUEST["sq"])) {
    $query = $_REQUEST["sq"];
  }

var_dump(COL::search($query)['hits']['hits']);

/*EOF*/