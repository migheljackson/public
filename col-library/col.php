<?php
/*
 * @name addActivityManagerButton
 * @description 
*/

$core_path = $modx->getOption('col_public.core_path','',MODX_CORE_PATH.'components/col_public/');
require_once $core_path.'vendor/autoload.php';

class COL {

  CONST SEARCH_INDEX = "dev";
  
  /*
   *  @name search
   *  @param $sQuery - String of test to search for
   *  @param $aTopics - Array of category names
   *  @param $iMinAge - Minimum age to search for
   *  @param $iMaxAge - Maximum age to search for
   *  @param $aLocations - Array of Locations - WIP
   *  @param $bPrice - true for nonfree, false for free, null for both
   *  @param $iPage - default to 0 - page number of the results 0 is the first
   *  @param $iPerPage - default to 12 - number or responses per page
   *
   */
  public static function search($sQuery = "", $aTopics = [], $iMinAge = 0, 
      $iMaxAge = 100, $bPrice = null, $aLocations=[], $iPage = 0, $iPerPage = 12) {
    $client = self::connect();

    $searchParams['index'] = self::SEARCH_INDEX;
    $searchParams['type']  = 'ScheduledProgram';
    //$searchParams['body']['query']['filter']['hide'] = 'false';

    $aQueryStringParameters = array();

    

    if (isset($sQuery) && strlen($sQuery) > 0) {
      array_push($aQueryStringParameters, $sQuery."*"); // not sure if we should add this
    }

    if (isset($aTopics) && count($aTopics) > 0) {
      // (categories.id:2 OR categories.id:4)
      $aInnerCats = array();
      for($i = 0; $i < count($aTopics); ++$i) {
        array_push($aInnerCats, "categories.id:".strval($aTopics[$i]));
      }
      array_push($aQueryStringParameters, implode(" OR ", $aInnerCats));
    }

    if (isset($iMinAge) && $iMinAge > 0) {
      array_push($aQueryStringParameters, "min_age:>=".strval($iMinAge));
    }
    if (isset($iMaxAge) && $iMaxAge > 0) {
      array_push($aQueryStringParameters, "max_age:<=".strval($iMaxAge));
    }

    if (isset($bPrice) && !is_null($bPrice) ) {
      if ($bPrice == true) {
        $sQp = "price:>0";
      } else {
        $sQp = "price:0";
      }
      array_push($aQueryStringParameters, $sQp);
    }
 
    // set hide to true
    $aHiddenTermQuery = array();
    $aHiddenTermQuery["term"]["hidden"] = false;

    $aQueryString = array();
    $sQS = "";
    foreach ($aQueryStringParameters as $qs) {
      $sQS .= "(".$qs.")";
    }
    $aQueryString["query_string"]["query"] = $sQS;
    
    $searchParams['body']['query']['bool']['must'] = array($aQueryString, $aHiddenTermQuery);
    $searchParams
    $queryResponse = $client->search($searchParams);

    return $queryResponse;
  }

  private static function connect() {
    $params = array();
    
    $searchServers = array("gopher.col-engine.c66.me:9200");
    //$searchServers = array("dragon.staging-col-engine.staging.c66.me:9200");
    //$searchServers = array("localhost:9200");
    $params['hosts'] = $searchServers;

    // TODO Drop LOGGING down to WARN
    //$params['logging'] = true;
    //$params['logPath'] = '/Applications/MAMP/logs/apache_error.log';
    //$params['logLevel'] = Psr\Log\LogLevel::INFO;

    $client = new Elasticsearch\Client($params);

    return $client;
  }
}


/*
// clean the index
curl -XDELETE 'http://localhost:9200/dev'
curl -XPUT 'http://localhost:9200/dev'


// setting up the geo point for location
curl -XPUT 'http://localhost:9200/dev/ScheduledProgram/_mapping' -d '
{
  
  "properties": {

         "location": {
             "type": "geo_point",
             "precision": "10m"
         },
         "categories": {
            "properties": {
                "id": {"type": "long"},
                "name": {"type": "string"},
                "description": {"type": "string"}
            }
         },
         "hidden": {
            "type": "boolean"
         }
    }
  
    
}'

curl -XPUT 'http://localhost:9200/chicago/ScheduledProgram/_mapping' -d '
{
  
  "properties": {
         "location": {
             "type": "geo_point",
             "precision": "10m"
         },
         "categories": {
            "properties": {
                "id": {"type": "long"},
                "name": {"type": "string"},
                "description": {"type": "string"}
            }
         },
         "hidden": {
            "type": "boolean"
         }
    }
  
    
}'


http://loadimpact.com/load-test/chicagocityoflearning.org-faa2d0acc5401cdc4cda72a6766d0636


// attempting location based search
localhost:9200/dev/ScheduledProgram/
GET _search 
{
   "query": {
       "query_string": {
          "query": "springfield*"
       }, 
       
       "geo_shape": {
          "location": {
             "shape": {
                "type": "polygon", 
                "coordinates": [[-87.6363976, 41.8772528], [-87.6363976, 41.8902152],[ -87.62131840000001, 41.8902152], [-87.62131840000001, 41.8772528], [-87.6363976, 41.8772528]]
             }
          }
          
       
       }
        
   
   }
}

POST _search 
{
   "query": {
       "bool": {
       "must": [ {
          "query_string": {
          "query": " price:0 AND (categories.id:2 OR categories.id:4) and program_type:\"workshop\" AND springfield* AND min_age:<8"
       }
       }, 
       {
       "term": {
           "hidden": true
       }
       }
       ]
       }, 

    "from": 0,
    "size": 2
      
      
        
   
   }
}


// search for type, price and ft

values price:0 for free
values price:>0 for non free

values program_type:\"workshop\"

use AND for filtering


GET _search 
{
   "query": {
       "query_string": {
          "query": "price:>0 AND program_type:\"workshop\" AND springfield*"
       }
    ,
    "size": 2
      
      
        
   
   }
}

// search with categories

GET _search 
{
   "query": {
       "query_string": {
          "query": "price:0 AND (categories.id:2 OR categories.id:4) and program_type:\"workshop\" AND springfield*"
       }
    ,
    "from": 0,
    "size": 2
      
      
        
   
   }
}

*/


?>