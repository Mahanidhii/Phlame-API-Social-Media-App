<?php 
$rootPath = dirname(__DIR__);

require_once($rootPath . '/serve/Router.php');
require_once($rootPath . '/serve/Source.php');
require_once($rootPath . '/serve/Apiconn.php');


$db_server = "localhost";
$db_user = "root";
$db_pass = "";
$db_name = "social_media";

global $conn;

//Exception Handling:
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try{
    $conn = mysqli_connect($db_server, $db_user, $db_pass, $db_name);
}
catch(Exception $e){
    http_response_code(500);
    header('Content-Type: application/json');
    echo json_encode(['error'=>'DB connection failed']);
    exit();
}
?>
