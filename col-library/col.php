<?php
/*
 * @name addActivityManagerButton
 * @description
*/

$core_path = $modx->getOption( 'col_public.core_path', '', MODX_CORE_PATH.'components/col_public/' );
require_once $core_path.'vendor/autoload.php';

class COL {

  const SEARCH_INDEX = "chicago";

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
        $term = array( 'term' => array( "categories.id" => intval( $aTopics[$i] ) ) );
        array_push( $catFilter['or']['filters'], $term );
      }

      array_push( $aFiltersParameters, $catFilter );
    }

    if ( isset( $aLocations )  && count( $aLocations )>0 ) {
      $location_shapes = array();
      foreach($aLocations as $locationSlug) {
        $l = self::get_location($locationSlug);
        if (isset($l)) {
          array_push($location_shapes, $l);
        }
      }

      if (count($location_shapes)>0) {
        $locationOrFilter = array();
        $locationOrFilter['or'] = array('filters' => array());

        foreach ($location_shapes as $shape ) {
          $locationShape = array();
          $locationShape["geo_shape"]["location"]["shape"]["type"]="polygon";
          $locationShape["geo_shape"]["location"]["shape"]["coordinates"] = array( $shape );
          array_push( $locationOrFilter["or"]["filters"], $locationShape );
        }

        array_push( $aFiltersParameters, $locationOrFilter );
      }

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
    if ( count( $aQueryStringParameters ) > 0 ) {
      $aQueryString["query_string"]["query"] = $sQuery."*" ;

      $searchParams['body']['query']['bool']['must'] = array( $aQueryString );
    } else {
      $searchParams['body']['query']["match_all"] = array( "boost"=>1 );
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

  private static function get_location( $slug ) {
    $locations = array();

    $locations["south_side"] = array( [-87.60223388671875, 41.859844975978454], [-87.74505615234375, 41.81533774847465], [-87.74162292480469, 41.76926321969369], [-87.79792785644531, 41.76772683171353], [-87.79449462890625, 41.63135419009182], [-87.3468017578125, 41.62930126680881], [-87.60223388671875, 41.859844975978454] );
    $locations["southwest_side"] = array( [-87.74059295654297, 41.81636125072051], [-87.82024383544922, 41.792816561051815], [-87.89474487304688, 41.71828672552955], [-87.83500671386719, 41.63084096540012], [-87.73612976074219, 41.631867410697474], [-87.74059295654297, 41.81636125072051] );
    $locations["downtown"] = array( [-87.61991500854492, 41.90419348703419], [-87.66231536865234, 41.90355467806868], [-87.65853881835938, 41.895760694064755], [-87.64566421508789, 41.88630442013054], [-87.64463424682617, 41.846291455009165], [-87.55331039428711, 41.875312937595815], [-87.61991500854492, 41.90419348703419] );
    $locations["west_side"] = array( [-87.64463424682617, 41.846291455009165], [-87.64566421508789, 41.88630442013054], [-87.66059875488281, 41.8999772297506], [-87.80548095703125, 41.897932883580076], [-87.80410766601562, 41.79665595947719], [-87.64463424682617, 41.846291455009165] );
    $locations["north_side"] = array( [-87.6544189453125, 41.899721690058364], [-87.61322021484375, 41.90534332706592], [-87.66609191894531, 42.06101883271296], [-87.77458190917969, 42.067135987500116], [-87.74986267089844, 41.96459591213679], [-87.68840789794922, 41.9282080659345], [-87.68754959106445, 41.8998494600323], [-87.6544189453125, 41.899721690058364] );
    $locations["north_west_side"] = array( [-87.68051147460938, 41.899721690058364], [-87.68840789794922, 41.9282080659345], [-87.74986267089844, 41.96459591213679], [-87.76668548583984, 42.04138898243176], [-87.8683090209961, 42.040624060291336], [-87.94452667236328, 42.021753065991184], [ -87.9510498046875, 41.95949009892467], [-87.83672332763672, 41.93804121581888], [-87.8360366821289, 41.89716623689334], [-87.68051147460938, 41.899721690058364] );

    return $locations[$slug];
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
             "type": "geo_shape",
             "precision": "10m"
         },
         "location_point": {
             "type": "geo_point"
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
             "type": "geo_shape",
             "precision": "10m"
         },
         "location_point": {
             "type": "geo_point"
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
// distance search
{
  "query": {
    "match_all": {

    },
    "filtered": {
      "filter": {
        "bool": {
          "must": [
              {
                  "geo_distance" : {
                "distance" : "1km",
                "location_point" : {
                    "lat" :  41.8,
                    "lon" : -87.63
                }
            }
              },
            {
              "term": {
                "hidden": false
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
