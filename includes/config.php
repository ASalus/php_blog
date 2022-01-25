<?php

$config = array(
    'title' => "Testing Blog",
    'db' => array(
        'server' => 'localhost',
        'username' => 'root',
        'password' => '',
        'name' => 'test_blog',
    ),
    'twitter' => 'https://twitter.com/elonmusk',
);

$path = $_SERVER['SERVER_NAME'] == 'production.host' ? '/' : 'projectName';

require "db.php";
?>