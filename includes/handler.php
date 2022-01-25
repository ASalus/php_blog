<?php
require '../includes/config.php';

function login_check($nickname, $password, $connection)
{
  $errors = array();
  if ($nickname == '') {
    $errors[] = 'Enter your nickname and password!';
  }
  if ($password == '') {
    $errors[] = 'Enter your nickname and password!';
  };

  $user = mysqli_query($connection, "SELECT * FROM `users` WHERE `login` = '$nickname' AND `password` = '$password'");
  if (empty($errors) && (mysqli_num_rows($user) > 0)) {
    return array(true, $errors, $user);
  }
  return array(false, $errors, $user);
}

function signup_check($nickname, $firstName=NULL, $secondName=NULL, $password, $email, $connection)
{
  $existing = mysqli_query($connection, "SELECT * FROM `users` WHERE `login` = '$nickname' OR `email` = '$email'");
  $errors = array();
  if ($nickname == '') {
    $errors[] = 'Enter your nickname!';
  }
  if ($password == '') {
    $errors[] = 'Enter your password!';
  };
  if ($password == '') {
    $errors[] = 'Enter your e-mail!';
  };
  if (mysqli_num_rows($existing) != 0) {
    $errors[] = 'User with similar nickname or e-mail already exist!';
  };

  if (empty($errors) && (mysqli_num_rows($existing) == 0)) {
    $user = mysqli_query($connection, "INSERT INTO `users` (`login`, `first_name`, `second_name`, `password`, `email`) 
    VALUES ('$nickname', '$firstName', '$secondName', '$password', '$email')");
    return array(true, $errors, mysqli_query($connection, "SELECT * FROM `users` WHERE `login` = '$nickname' OR `email` = '$email'"));
  }
  return array(false, $errors, false);
}
