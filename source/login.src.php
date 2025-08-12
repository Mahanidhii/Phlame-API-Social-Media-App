<?php
Source::empty($type,'json');
global $conn;

Api::body(
    key:"username",
    then: function($rout) use ($conn, $type){
        $data = json_decode($rout['data'],true);
        $username = $data['username'] ?? '';
        $password = $data['password'] ?? '';

        // Verify user & pass
        if (empty($username)||empty($password)){
            Api::status(400);
            $segment = Api::segment('error',["message"=>"Username & Passwor Required..."]);
            Api::send($segment, format:$type);
            return;
        }

        try{
            $sql = "SELECT id, password FROM users WHERE username = ? LIMIT 1";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "s", $username);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            $user = mysqli_fetch_assoc($result);
            if ($user && password_verify($password, $user['password'])){
                $_SESSION['user_id']=$user['id'];
                $_SESSION['username']=$username;

                Api::status(200);

                $segment=Api::segment('data',["status"=>"success", "message" => "Login successful."]);

                Api::send($segment, format:$type);
            }
            else{
                Api::status(401);
                $segment = Api::segment('error',["message"=>"Invalid login credentials"]);
                Api::send($segment, format: $type);
            }
        }
        catch (Exception $e){
            Api::status(500);
            $segment = Api::segment('error',["message"=>"Error occured during login"]);
            Api::send($segment, format:$type);
        }
    },
    orelse: function() use ($type){
        Api::status(400);
        $segment = Api::segment('error',["message"=>"Request body missing/invalid"]);
        Api::send($segment, format:$type);
        

    }
);





?>