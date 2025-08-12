<?php
Source::empty($type, 'json');
global $conn;

if (!isset($_SESSION['user_id'])){
    Api::status(401);
    $segment = Api::segment('error', ["message" => "Log in to like a post."]);
    Api::send($segment, format: $type);
    exit();
}

if (!isset($post_id) || !is_numeric($post_id)){
    Api::status(400);
    $segment = Api::segment('error', ["message" => "Invalid post ID"]);
    Api::send($segment, format: $type);
    exit();
}

$user_id=$_SESSION['user_id'];

try{
    $sql="INSERT INTO likes (user_id, post_id) VALUES (?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ii", $user_id, $post_id);
    mysqli_stmt_execute($stmt);

    Api::status(201);
    $segment = Api::segment('data', ["status" => "success", "message" => "Post liked successfully."]);
    Api::send($segment, format: $type);
}
catch (Exception $e){ 
    if (mysqli_errno($conn)==1062){
        Api::status(409);
        $segment=Api::segment('error',["message"=>"You have already liked this post"]);

    }
    else{
        Api::status(500);
        $segment=Api::segment('error',["message" => "An error occurred while liking the post"]);

    }
    Api::send($segment, format:$type);
}




?>