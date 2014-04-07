<?php
/*
 * @name addActivityManagerButton
 * @description
*/

$core_path = $modx->getOption( 'col_public.core_path', '', MODX_CORE_PATH.'components/col_public/' );
require_once $core_path.'vendor/autoload.php';

class COL {

  const SEARCH_INDEX = "dev";

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
  public static function search( $sQuery = "", $aTopics = array() , $iMinAge = 0,
    $iMaxAge = 100, $bPrice = null, $aLocations=array(), $iPage = 0, $iPerPage = 15 ) {
    $client = self::connect();

    $searchParams['index'] = self::SEARCH_INDEX;
    $searchParams['type']  = 'ScheduledProgram';
    //$searchParams['body']['query']['filter']['hide'] = 'false';



    $aQueryStringParameters = array();

    $aFiltersParameters = array();

    if ( isset( $sQuery ) && strlen( $sQuery ) > 0 ) {
      array_push( $aQueryStringParameters, $sQuery."*" ); // not sure if we should add this
    } else {
      //array_push( $aQueryStringParameters, "*" );
    }

    if ( isset( $aTopics ) && count( $aTopics ) > 0 ) {
      // (categories.id:2 OR categories.id:4)
      $aInnerCats = array();
      $catFilter = array();
      $catFilter['or'] =  array( 'filters' =>array() );
      for ( $i = 0; $i < count( $aTopics ); ++$i ) {
        $term = array( 'term' => array( "categories.id" => intval($aTopics[$i]) ) );
        array_push( $catFilter['or']['filters'], $term );
      }

      array_push( $aFiltersParameters, $catFilter );
    }

    if ( isset( $iMinAge ) && $iMinAge > 0 ) {
      $range = array( 'range'=>array( 'min_age' => array( 'from' => $iMinAge  ) ) );
      array_push( $aFiltersParameters, $range );
    }
    if ( isset( $iMaxAge ) && $iMaxAge > 0 ) {
      $range = array( 'range'=>array( 'max_age' => array( 'to' =>  $iMaxAge  ) ) );
      array_push( $aFiltersParameters, $range );
    }

    if ( isset( $bPrice ) && !is_null( $bPrice ) ) {
      if ( $bPrice == true ) {
        $range = array( 'range'=>array( 'price' => array( 'from' => 1 ) ) );

      } else {
        $range = array( 'term'=>array( 'price' => 0 ) );

      }
      array_push( $aFiltersParameters, $range );
    }

    // set hide to true
    $aHiddenTermQuery = array();
    $aHiddenTermQuery["term"]["hidden"] = false;
    array_push( $aFiltersParameters, $aHiddenTermQuery );
    if(count($aQueryStringParameters) > 0) {
          $aQueryString["query_string"]["query"] = $sQuery."*" ;

      $searchParams['body']['query']['bool']['must'] = array( $aQueryString );
    } else {
       $searchParams['body']['query']["match_all"] = array("boost"=>1);
    }
   

    $searchParams['body']['query']['filtered']['filter']['bool']['must'] = $aFiltersParameters;

    $searchParams["from"] = $iPage * $iPerPage;
    $searchParams["size"] = $iPerPage;
    $queryResponse = $client->search( $searchParams );
   
    return $queryResponse;
  }

  public static function document_get( $iDocumentId, $sDocumentType ) {
    $client = self::connect();
    $aGetParams =  array( 'id' => $iDocumentId, 'index' => self::SEARCH_INDEX, 'type' => $sDocumentType, '_source' => true );
    return $client->get( $aGetParams );
  }

  private static function connect() {
    $params = array();
    //$searchServers = array("dragon.staging-col-engine.staging.c66.me:9200");
    $searchServers = array( "localhost:9200" );
    $params['hosts'] = $searchServers;

    // TODO Drop LOGGING down to WARN
    $params['logging'] = true;
    $params['logPath'] = '/Applications/MAMP/logs/apache_error.log';
    //$params['logPath'] = '/var/www/beta.explorechi.com/public_html/core/cache/logs/error.log';
    $params['logLevel'] = Psr\Log\LogLevel::INFO;

    $client = new Elasticsearch\Client( $params );

    return $client;
  }
}


/*
// clean the index
curl -XDELETE 'http://localhost:9200/dev'
curl -XPUT 'http://localhost:9200/dev'

curl -XDELETE 'http://localhost:9200/chicago'
curl -XPUT 'http://localhost:9200/chicago'


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

{
  "query": {
    "bool": {
      "must": [
        {
          "query_string": {
            "query": " price:0 AND (categories.id:2 OR categories.id:4) and program_type:\"workshop\""
          }
        },
        {
          "term": {
            "hidden": false
          }
        }
      ]
    },
    "filtered": {
      "filter": {
        "bool": {
          "must": [
            {
              "term": {
                "categories.id": 2
              }
            },
            {
              "range": {
                "min_age": {
                  "from": 0,
                  "to": 7
                }
              }
            },
            {
              "range": {
                "max_age": {
                  "from": 7,
                  "to": 8
                }
              }
            },{
              "range": {
                "price": {
                  "from": 1

                }
              }
            }
          ]
        }
      }
    }
  },
  "from": 0,
  "size": 10
}

*/


?>
