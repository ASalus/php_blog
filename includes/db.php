<?php

$connection = mysqli_connect(
    $config['db']['server'],
    $config['db']['username'],
    $config['db']['password'],
    $config['db']['name']
);

if(!isset($_SESSION)) 
{ 
    session_start(); 
} 

if ($connection == false) {
    echo "Error ocurred";
    echo mysqli_connect_error();
    exit();
}
?>