<?php
Source::empty($type, 'json');
global $conn;

if (!isset($_SESSION['user_id'])) {
    Api::status(401); 
    $segment = Api::segment('error', ["message" => "Log in to create a post."]);
    Api::send($segment, format: $type);
    exit();
}
Api::body(
    key: "content",
    then: function($rout) use ($conn, $type){
        $data = json_decode($rout['data'], true);
        $content = $data['content'] ?? '';
        $user_id = $_SESSION['user_id']; 

        if (empty($content)){
            Api::status(400);
            $segment = Api::segment('error', ["message"=>"Post content cannot be empty."]);
            Api::send($segment, format: $type);
            return;
        }

        try {
            $sql = "INSERT INTO posts (user_id, content) VALUES (?, ?)";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "is", $user_id, $content); 
            mysqli_stmt_execute($stmt);

            Api::status(201); // Created
            $segment = Api::segment('data', ["status" => "success", "message" => "Post created successfully."]);
            Api::send($segment, format: $type);

        } catch (Exception $e) {
            Api::status(500);
            $segment = Api::segment('error', ["message" => "An error occurred while creating the post."]);
            Api::send($segment, format: $type);
        }
    },
    orelse: function() use ($type) {
        Api::status(400);
        $segment = Api::segment('error', ["message" => "Request body is missing or invalid."]);
        Api::send($segment, format: $type);
    }
);


?>