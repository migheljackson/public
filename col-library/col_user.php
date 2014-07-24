<?php
/*
 * @name col_user
 * @description
*/

require_once 'Authentication/JWT.php';
require_once 'curl_helpers.php';


class COL_User {



  public static function set_avatar( $preset_avatar_id ) {
    $user = array( 'user' => array( 'preset_avatar_id' => $preset_avatar_id ), 'token' => COL::_get_token() );

    $response = COL::post_encrypted_json( '/users/set_avatar.json', $user );

    $parsed_response = JWT::jsonDecode( $response );

    if ( $parsed_response->status == 200 || $parsed_response->status == 201 ) {
      setcookie( COL::COOKIE_NAME_AU, JWT::encode( $parsed_response->result, COL::KEY ), time()+COL::SESSION_TIME );
    }
    return $response;
  }

  // email won't work for now
  public static function signin( $username, $password ) {
    $endpoint = '/user_session/create.json';
    $user = array( 'username' => $username, 'password' => $password ) ;

    $response = COL::post_encrypted_json( $endpoint , $user );

    $parsed_response = JWT::jsonDecode( $response );

    if ( $parsed_response->status == 200 || $parsed_response->status == 201 ) {

      setcookie( COL::COOKIE_NAME_AU, JWT::encode( $parsed_response->result->user, COL::KEY ), time()+COL::SESSION_TIME );
    }
    return $response;
  }

  public static function signout( $username, $password ) {
    $endpoint = '/user_session/destroy.json';

    $response = COL::get( $endpoint  );

    setcookie( COL::COOKIE_NAME_AU, "", time()-COL::SESSION_TIME );

    return $response;
  }


  public static function get_profile() {
    $endpoint = '/users/profile.json';
    $response = COL::get( $endpoint  );
    return $response;
  }
  
  public static function validate_external_user($dob, $name, $id) {
  	$endpoint = '/users/validate_external_sys_id.json';
  	$user = array('external_sys_id' => $id, 'full_name' => $name, 'dob' => $dob);
  	$response = COL::post_encrypted_json($endpoint, array("user"=>$user));
  
  	return $response;
  }
  
  public static function validate_claim_code($dob, $name, $code) {
  	$endpoint = '/users/validate_account_claim_code.json';
  	$user = array('claim_code' => $code, 'full_name' => $name, 'dob' => $dob);
  	$response = COL::post_encrypted_json($endpoint, array("user"=>$user));
  
  	return $response;
  }

  public static function update_account( $id, $username, $full_name, $dob, $password, $email_address,
    $guardian_email_address, $guardian_name, $guardian_phone ) {
    $params = array( 'user' => array( 'id' => $id ,
        'username' =>  $username,
        'full_name' => $full_name,
        'dob' => $dob,
        'password' => $password,
        'guardian_email_address' => $guardian_email_address,
        'email_address' => $email_address,
        'guardian_name' => $guardian_name,
        'guardian_phone' => $guardian_phone

      ) );

    $response = COL::put( '/users/'.strval( $id ).'.json', $params );
    $success = false;
    if ( $response->status==200 ) {
      $success = true;
      $response->result->full_name = null;
      $response->result->guardian_name = null;
      $response->result->guardian_phone = null;
      $response->result->guardian_email_address = null;
      $response->result->dob = null;

      setcookie( COL::COOKIE_NAME_AU, JWT::encode( $response->result, COL::KEY ), time()+COL::SESSION_TIME );
    }
    COL::log_action( 'update_account', array( 'extra_params' => array( 'status' => $response->status, 'success' => $success ) ) );


    return $response;
  }
}
