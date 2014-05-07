<?php
/*
 * @name col_user
 * @description
*/

require_once 'Authentication/JWT.php';
require_once 'curl_helpers.php';


class COL_User {

  public static function set_avatar($preset_avatar_id) {
    $user = array( 'user' => array('preset_avatar_id' => $preset_avatar_id), 'token' => COL::_get_token() );

    $response = COL::post_encrypted_json( '/users/set_avatar.json', $user );

    $parsed_response = JWT::jsonDecode($response);

    if($parsed_response->status == 200 || $parsed_response->status == 201) {
      setcookie(COL::COOKIE_NAME_AU, JWT::encode($parsed_response->result, COL::KEY), time()+COL::SESSION_TIME );
    }
    return $response;
  }

  // email won't work for now
  public static function signin($username, $password) {
    $endpoint = '/user_session/create.json';
    $user = array('username' => $username, 'password' => $password) ;

    $response = COL::post_encrypted_json( $endpoint , $user );

    $parsed_response = JWT::jsonDecode($response);

    if($parsed_response->status == 200 || $parsed_response->status == 201) {
      
      setcookie(COL::COOKIE_NAME_AU, JWT::encode($parsed_response->result, COL::KEY), time()+COL::SESSION_TIME );
    }
    return $response;
  }

  public static function signout($username, $password) {
    $endpoint = '/user_session/destroy.json';

    $response = COL::get( $endpoint  );
  
    setcookie(COL::COOKIE_NAME_AU, "", time()-COL::SESSION_TIME );
    
    return $response;
  }
}