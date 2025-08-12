<?php
Source::empty($type, 'json');
global $conn;
try {

    $sql = "
        SELECT 
            p.id, 
            p.content, 
            p.created_at, 
            u.username,
            (SELECT COUNT(*) FROM likes WHERE post_id = p.id) as like_count
        FROM posts p
        JOIN users u ON p.user_id = u.id
        ORDER BY p.created_at DESC
    ";

    $result = mysqli_query($conn, $sql);
    $posts = mysqli_fetch_all($result, MYSQLI_ASSOC);

    Api::status(200);
    $segment = Api::segment('posts', $posts);
    Api::send($segment, format: $type);

} 
catch (Exception $e){
    Api::status(500);
    $segment = Api::segment('error', ["message" => "An error occurred while fetching posts.", "details" => $e->getMessage()]);
    Api::send($segment, format: $type);
}
?>
