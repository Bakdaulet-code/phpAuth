<?php

if( $_SERVER['REQUEST_METHOD'] == 'POST' ){
  $email = $_SESSION['email'];

  $pass1= $_POST['pass1'] ?? '';
  $pass2= $_POST['pass2'] ?? '';
  
  $_SESSION['message'] = [];

  if( !$pass1 || !$pass2 ) {
    $_SESSION['message'][] = 'Set password and confirmation';
    header('Location: /');
    exit;
  }
  if( $pass1 != $pass2 ) {
    $_SESSION['message'][] = 'Specify the same passwords';
    header('Location: /');
    exit;
  }
  
  $stmt = mysqli_stmt_init($db);
  if (mysqli_stmt_prepare($stmt, "UPDATE users SET pass=? WHERE email=?")) {

    $pass = password_hash($pass1, PASSWORD_BCRYPT, ['cost' => 12,]);
    mysqli_stmt_bind_param($stmt, "ss", $pass, $email);
    mysqli_stmt_execute($stmt);

    $_SESSION['message'][] = 'Password changed';
    header('Location: /');   
    exit; 
  }


}