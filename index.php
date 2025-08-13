<?php 
session_start();
require_once '.config/_init.php'; 

$router = new Router();

$router->addRoute('/', function() {
  Source::set("index");
});

$router->addRoute('/users/register', function() {
  Source::set("register");
}, 'POST');

//route for the user login
$router->addRoute('/login',function(){
  Source::set("login");
}, 'POST');

//route for making posts:
$router->addRoute('/posts',function(){
  Source::set("create_post");
}, 'POST');

//route for getting the posts:
$router->addRoute('/posts', function(){
  Source::set("get_posts");
}, 'GET');

//route for like a particular post:
$router->addRoute('/posts/<id>/like', function($id){
    Source::set('like_post', ['post_id' => $id]);
}, 'POST');




$router->route();







?>
  