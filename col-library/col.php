<?php
/*
 * @name addActivityManagerButton
 * @description
*/

require_once 'Authentication/JWT.php';
require_once 'curl_helpers.php';

$core_path = $modx->getOption( 'col_public.core_path', '', MODX_CORE_PATH.'components/col_public/' );
require_once $core_path.'vendor/autoload.php';

class COL {

  const SEARCH_INDEX = "chicago";
  const BASE_URL = "http://chicago.lvh.me:3001";
  //const BASE_URL = "http://dev.col-engine-staging.com/";
  const COOKIE_NAME = "user_token";
  const KEY = "n1ght1f4ll0ft3rr0rs!";
  const SESSION_TIME = 12000;
  const COOKIE_NAME_NAME = "_user_name";
  const COOKIE_NAME_AU = "_us__";



  public static function _get_token() {
    if (isset($_COOKIE[self::COOKIE_NAME_AU])) {
       $au_cookie = JWT::decode( $_COOKIE[self::COOKIE_NAME_AU], self::KEY );
      if ( isset( $au_cookie ) && $au_cookie != null ) {
        return $au_cookie->token;
      } else {
        return "";
      }
    }
    return "";

  }

  public static function _get_jwt_token() {
    if (isset($_COOKIE[self::COOKIE_NAME_AU])) {

      $au_cookie = JWT::decode( $_COOKIE[self::COOKIE_NAME_AU], self::KEY );
      if ( isset( $au_cookie ) && $au_cookie != null ) {
        return $au_cookie->jwt_token;
      } else {
        return "";
      }
    }

  }


  public static function _get_avatar_image() {
    $au_cookie = JWT::decode( $_COOKIE[self::COOKIE_NAME_AU], self::KEY );
    return $au_cookie->preset_avatar_url;
  }

  public static function _get_name() {
    $au_cookie = JWT::decode( $_COOKIE[self::COOKIE_NAME_AU], self::KEY );
    return $au_cookie->username;
  }

  public static function get( $endpoint ) {
    $aResponse = array();

    $token = array(
      "payload" =>  array( 'token' => self::_get_token() ),
      "exp" => time() + 30,
    );
    $jwt = JWT::encode( $token, self::KEY );
    $data = array( "jwt" => $jwt );

    $url =  self::BASE_URL.$endpoint.'?jwt='.$jwt;

    $response = WWW::get( $url );

    try {
      $aResponse = JWT::jsonDecode( $response );
    } catch ( Exception $ex ) {
      error_log( "COL::get():" . $ex . " resp: ". print_r( $response ) );
    }
    return $aResponse;
  }

  public static function is_signed_in() {
    return isset( $_COOKIE[self::COOKIE_NAME_AU]) ; 
  }

  public static function log_action($action, $other_params) {
    try {
      if (self::is_signed_in()) {
        $response = self::post_json('/user_logs/log.json', array('token' => self::_get_token(), 'action' => $action, 'other_params' => $other_params ));
      } else {
        $response = self::post_json('/user_logs/anon_log.json', array( 'action' => $action, 'other_params' => $other_params ));
      }
      
    } catch (Exception $e) {
      
    }
    
  }

  public static function login( $username, $password ) {
    $payload = array(
      "username" => $username,
      "password" => $password
    );

    $endpoint = '/user_session/create.json';
    $decoded = self::post_encrypted( $endpoint, $payload );
    return $decoded;
  }

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
   *  @param $types - "ScheduledProgram,Pathway"  or one of either
   *
   */
  public static function search( $sQuery = "", $aTopics = array() , $iMinAge = 0,
    $iMaxAge = 100, $bPrice = null, $aLocations=array(), $iPage = 0, $iPerPage = 15, $latitude = null, $longitude = null, $distance = null, $types="ScheduledProgram,Pathway" ) {
    $client = self::connect();

    $searchParams['index'] = self::SEARCH_INDEX;
    $searchParams['type']  = $types;
    //$searchParams['body']['query']['filter']['hide'] = 'false';
    //var_dump($types);


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
      foreach ( $aLocations as $locationSlug ) {
        $l = self::get_location( $locationSlug );
        if ( isset( $l ) ) {
          array_push( $location_shapes, $l );
        }
      }

      if ( count( $location_shapes )>0 ) {
        $locationOrFilter = array();
        $locationOrFilter['or'] = array( 'filters' => array() );

        foreach ( $location_shapes as $shape ) {
          $locationShape = array();
          $locationShape["geo_shape"]["location"]["shape"]["type"]="polygon";
          $locationShape["geo_shape"]["location"]["shape"]["coordinates"] = array( $shape );
          array_push( $locationOrFilter["or"]["filters"], $locationShape );
        }

        array_push( $aFiltersParameters, $locationOrFilter );
      }

    }

    /*"geo_distance" : {
                "distance" : "1km",
                "location_point" : {
                    "lat" :  41.8,
                    "lon" : -87.63
                }
                var_dump($latitude);var_dump($distance);var_dump($longitude);
*/
    if ( isset( $latitude ) && isset( $longitude ) && isset( $distance ) ) {

      $geo_distance = array();
      $geo_distance["geo_distance"] = array();
      $geo_distance["geo_distance"]["distance"] = $distance;
      $geo_distance["geo_distance"]["location_point"]["lat"] = floatval( $latitude );
      $geo_distance["geo_distance"]["location_point"]["lon"] = floatval( $longitude );
      //var_dump($geo_distance);

      array_push( $aFiltersParameters, $geo_distance );

      $searchParams["sort"] = array( array( '_geo_distance' => array( 'location_point' => array( floatval( $longitude ),  floatval( $latitude ) ), "order" => "asc", "unit" => "km" ) , ) );
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

    $date_range = array( 'range'=>array( 'end_date' => array( 'gte' => date("Y-m-d") ) ) );
     array_push( $aFiltersParameters, $date_range );
    // set hide to true
    $aHiddenTermQuery = array();
    $aHiddenTermQuery["term"]["hidden"] = false;
    array_push( $aFiltersParameters, $aHiddenTermQuery );
    if ( count( $aQueryStringParameters ) > 0 ) {
      $aQueryString["query_string"]["query"] = $sQuery."*" ;
      $aQueryString["query_string"]["fields"] = array( "description", "name^5" );

      $searchParams['body']['query']['bool']['must'] = array( $aQueryString );
    } else {
      $searchParams['body']['query']["match_all"] = array( "boost"=>1 );
    }


    $searchParams['body']['query']['filtered']['filter']['bool']['must'] = $aFiltersParameters;

    $searchParams["from"] = $iPage * $iPerPage;
    $searchParams["size"] = $iPerPage;

    //var_dump(JWT::jsonEncode($searchParams));
    $queryResponse = $client->search( $searchParams );

    return $queryResponse;
  }

  public static function document_get( $iDocumentId, $sDocumentType ) {
    $client = self::connect();
    $aGetParams =  array( 'id' => $iDocumentId, 'index' => self::SEARCH_INDEX, 'type' => $sDocumentType, '_source' => true );
    return $client->get( $aGetParams );
  }

  public static function post( $endpoint, $payload ) {
    $aResponse = array();

    $token = array(
      //'token' => $_COOKIE[self::COOKIE_NAME],
      "payload" => $payload,
      "exp" => time() + 60,
    );
    $jwt = JWT::encode( $token, self::KEY );
    $data = array( "jwt" => $jwt );

    $url =  self::BASE_URL.$endpoint;

    $response = WWW::post( $url, $data );

    try {
      $aResponse = JWT::jsonDecode( $response );
    } catch ( Exception $ex ) {
      error_log( "COL::post():" . $ex . " resp: ". print_r( $response ) );
    }
    return $aResponse;
  }

  public static function post_encrypted($endpoint, $payload) 
  {
    $aResponse = array();

    $token = array(
      "payload" => $payload,
      "exp" => time() + 60,
      );
    $jwt = JWT::encode($token, self::KEY);
    $data = array("jwt" => $jwt);

    $url =  self::BASE_URL.$endpoint;
     
    $response = WWW::post($url, $data);
    try {
        $aResponse = JWT::jsonDecode(JWT::decode($response, self::KEY));
    } catch (Exception $ex){
        error_log("COL::post_encrypted():" . $ex . " resp: ". print_r($response));
    }
    return $aResponse;
  }

  public static function post_encrypted_json($endpoint, $payload) 
  {
    $aResponse = array();

    $token = array(
      "payload" => $payload,
      "exp" => time() + 60,
      );
    $jwt = JWT::encode($token, self::KEY);
    $data = array("jwt" => $jwt);

    $url =  self::BASE_URL.$endpoint;
     
    $response = WWW::post($url, $data);
    try {
        $aResponse = JWT::decode($response, self::KEY);
    } catch (Exception $ex){
        error_log("COL::post_encrypted():" . $ex . " resp: ". print_r($response));
    }
    return $aResponse;
  }

  public static function post_json( $endpoint, $payload ) {
    $aResponse = array();

    $token = array(
      //'token' => $_COOKIE[self::COOKIE_NAME],
      "payload" => $payload,
      "exp" => time() + 60,
    );
    $jwt = JWT::encode( $token, self::KEY );
    $data = array( "jwt" => $jwt );

    $url =  self::BASE_URL.$endpoint;

    $response = WWW::post( $url, $data );

    return $response;
  }

  public static function put($endpoint, $payload) 
  {
    $aResponse = array();
    $payload['token'] = self::_get_token();
    $token = array(
      "payload" => $payload,
      "exp" => time() + 60,
      
      );
    $jwt = JWT::encode($token, self::KEY);
    $data = array("jwt" => $jwt, "_method" => "put");

    $url =  self::BASE_URL.$endpoint;
     
    $response = WWW::post($url, $data);
    try {
        $aResponse = JWT::jsonDecode($response);
    } catch (Exception $ex){
        error_log("COL::put():" . $ex . " resp: ". print_r($response));
    }
    return $aResponse;
  }


  public static function system_get( $endpoint ) {
    $aResponse = array();

    $token = array(
      "payload" =>  array(),
      "exp" => time() + 30,
    );
    $jwt = JWT::encode( $token, self::KEY );
    $data = array( "jwt" => $jwt );

    $url =  self::BASE_URL.$endpoint.'?jwt='.$jwt;

    $response = WWW::get( $url );

    try {
      $aResponse = JWT::jsonDecode( $response );
    } catch ( Exception $ex ) {
      error_log( "COL::get():" . $ex . " resp: ". print_r( $response ) );
    }
    return $aResponse;
  }

  private static function connect() {
    $params = array();
    
    //$searchServers = array("gopher.col-engine.c66.me:9200");
    // $searchServers = array("dragon.staging-col-engine.staging.c66.me:9200");
    $searchServers = array("localhost:9200");
    $params['hosts'] = $searchServers;

    // TODO Drop LOGGING down to WARN
    $params['logging'] = true;
    $params['logPath'] = '/Applications/MAMP/logs/apache_error.log';
    $params['logLevel'] = Psr\Log\LogLevel::INFO;

    $client = new Elasticsearch\Client( $params );

    return $client;
  }

  private static function get_location( $slug ) {
    $locations = array();

    $locations["south_side"] = array( array( -87.60223388671875, 41.859844975978454 ), array( -87.74505615234375, 41.81533774847465 ), array( -87.74162292480469, 41.76926321969369 ), array( -87.79792785644531, 41.76772683171353 ), array( -87.79449462890625, 41.63135419009182 ), array( -87.3468017578125, 41.62930126680881 ), array( -87.60223388671875, 41.859844975978454 ) );
    $locations["southwest_side"] = array( array( -87.74059295654297, 41.81636125072051 ), array( -87.82024383544922, 41.792816561051815 ), array( -87.89474487304688, 41.71828672552955 ), array( -87.83500671386719, 41.63084096540012 ), array( -87.73612976074219, 41.631867410697474 ), array( -87.74059295654297, 41.81636125072051 ) );
    $locations["downtown"] = array( array( -87.61991500854492, 41.90419348703419 ), array( -87.66231536865234, 41.90355467806868 ), array( -87.65853881835938, 41.895760694064755 ), array( -87.64566421508789, 41.88630442013054 ), array( -87.64463424682617, 41.846291455009165 ), array( -87.55331039428711, 41.875312937595815 ), array( -87.61991500854492, 41.90419348703419 ) );
    $locations["west_side"] = array( array( -87.64463424682617, 41.846291455009165 ), array( -87.64566421508789, 41.88630442013054 ), array( -87.66059875488281, 41.8999772297506 ), array( -87.80548095703125, 41.897932883580076 ), array( -87.80410766601562, 41.79665595947719 ), array( -87.64463424682617, 41.846291455009165 ) );
    $locations["north_side"] = array( array( -87.6544189453125, 41.899721690058364 ), array( -87.61322021484375, 41.90534332706592 ), array( -87.66609191894531, 42.06101883271296 ), array( -87.77458190917969, 42.067135987500116 ), array( -87.74986267089844, 41.96459591213679 ), array( -87.68840789794922, 41.9282080659345 ), array( -87.68754959106445, 41.8998494600323 ), array( -87.6544189453125, 41.899721690058364 ) );
    $locations["north_west_side"] = array( array( -87.68051147460938, 41.899721690058364 ), array( -87.68840789794922, 41.9282080659345 ), array( -87.74986267089844, 41.96459591213679 ), array( -87.76668548583984, 42.04138898243176 ), array( -87.8683090209961, 42.040624060291336 ), array( -87.94452667236328, 42.021753065991184 ), array( -87.9510498046875, 41.95949009892467 ), array( -87.83672332763672, 41.93804121581888 ), array( -87.8360366821289, 41.89716623689334 ), array( -87.68051147460938, 41.899721690058364 ) );

    return $locations[$slug];
  }
}


/*
// clean the index
curl -XDELETE 'http://localhost:9200/dev'
curl -XPUT 'http://localhost:9200/dev'

curl -XDELETE 'http://localhost:9200/pitt'
curl -XPUT 'http://localhost:9200/pitt'


// setting up the geo point for location
curl -XPUT 'http://localhost:9200/pitt/ScheduledProgram/_mapping' -d '
{

  "properties": {
         "name": {
            "type": "string",
            "boost": 5.0
         },
        "description": {
            "type": "string",
            "boost": 1.5
         },
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
                "name": {"type": "string", "index": "not_analyzed", store: false, "boost": 0.1},
                "description": {"type": "string", "index": "not_analyzed", store: false, "boost": 0.1}
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
         "name": {
            "type": "string",
            "index": "analyzed",
            "boost": 10.0
         },
        "description": {
            "type": "string",
            "index": "analyzed",
            "boost": 1.0
         },
         "location_name": {
            "type": "string",
            "index": "analyzed",
            "boost": 0.5
         },
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
                "name": {"type": "string", "index": "no", store: false, "boost": 0.1},
                "description": {"type": "string", "index": "no", store: false, "boost": 0.1}
            }
         },
         "hidden": {
            "type": "boolean"
         }
    }


}'

curl -XDELETE 'http://localhost:9200/chicago/ScheduledProgram/ScheduledProgram_2962'

curl -XDELETE 'http://localhost:9200/dallas'
curl -XPUT 'http://localhost:9200/dallas'

curl -XPUT 'http://localhost:9200/dallas/ScheduledProgram/_mapping' -d '
{

  "properties": {
         "name": {
            "type": "string",
            "index": "analyzed",
            "boost": 10.0
         },
        "description": {
            "type": "string",
            "index": "analyzed",
            "boost": 1.0
         },
         "location_name": {
            "type": "string",
            "index": "analyzed",
            "boost": 0.5
         },
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
                "name": {"type": "string", "index": "no", store: false, "boost": 0.1},
                "description": {"type": "string", "index": "no", store: false, "boost": 0.1}
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
