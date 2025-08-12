<?php
Source::empty($type, 'json');
global $conn; 
$json_data = file_get_contents('php://input');
$data = json_decode($json_data, true);

if ($data === null){
    Api::status(400); // Bad Request
    $segment = Api::segment('error', ["message" => "Failed to parse request body as JSON."]);
    Api::send($segment, format: $type);
    exit();
}

$username = $data['username'] ?? '';
$password = $data['password'] ?? '';

if (empty($username) || empty($password)){
    Api::status(400); // Bad Request
    $segment = Api::segment('error', ["message" => "Username and password are required."]);
    Api::send($segment, format: $type);
    exit();
}

// Doesn't allow spaces in the username
// if (preg_match('/\s/', $username)){
    //     Api::status(400);
    //     $segment = Api::segment('error',["message"=>"USERNAME CANNOT CONTAIN SPACES!!"]);
    //     Api::send($segment, format: $type);
    //     return; 
    // }

$hashed_password = password_hash($password, PASSWORD_DEFAULT);
try{
    $sql = "INSERT INTO users (username, password) VALUES (?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ss", $username, $hashed_password);
    mysqli_stmt_execute($stmt);

    Api::status(201); // 201 Created
    $segment = Api::segment('data', ["status" => "success", "message" => "User registered successfully."]);
    Api::send($segment, format: $type);

} 
catch (Exception $e){
    if (mysqli_errno($conn) == 1062){
        Api::status(409);
        $segment = Api::segment('error', ["message" => "Username already exists."]);
    } 
    else{
        Api::status(500);
        $segment = Api::segment('error', ["message" => "An error occurred during registration."]);
    }
    Api::send($segment, format: $type);
}
?>

    
        
        