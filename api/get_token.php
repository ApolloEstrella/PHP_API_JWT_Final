<?php
require "../vendor/autoload.php";
use \Firebase\JWT\JWT;

/* header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With"); 
header('WWW-Authenticate: Basic realm="Test Authentication System"'); */

$valid_user = "a";
$valid_password = "b";


$user = $_SERVER['PHP_AUTH_USER'];
$pass = $_SERVER['PHP_AUTH_PW'];

$validated =  ($user == $valid_user) && ($pass == $valid_password);

if ($validated) {
    $data = json_decode(file_get_contents("php://input"));
    $secret_key = "YOUR_SECRET_KEY";
    $issuer_claim = "THE_ISSUER"; // this can be the servername
    $audience_claim = "THE_AUDIENCE";
    $issuedat_claim = time(); // issued at
    $notbefore_claim = $issuedat_claim + 10; //not before in seconds
    $expire_claim = $issuedat_claim + 60; // expire time in seconds
    $token = array(
        "iss" => $issuer_claim,
        "aud" => $audience_claim,
        "iat" => $issuedat_claim,
        "nbf" => $notbefore_claim,
        "exp" => $expire_claim /* ,
            "data" => array(
                "id" => $id,
                "firstname" => $firstname,
                "lastname" => $lastname,
                "email" => $email
            ) */
    );

    http_response_code(200);

    $jwt = JWT::encode($token, $secret_key);
    echo json_encode(
        array(
            //"message" => "Successful login.",
            "jwt" => $jwt
            //"email" => $email,
            //"expireAt" => $expire_claim
        )        
    );
    return json_encode(
        array(
            //"message" => "Successful login.",
            "jwt" => $jwt
            //"email" => $email,
            //"expireAt" => $expire_claim
        )        
    ); 
} else {
    header('WWW-Authenticate: Basic realm="My Realm"');
    header('HTTP/1.0 401 Unauthorized');
    die("Not authorized");
}
