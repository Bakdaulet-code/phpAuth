<?php

$stmt = mysqli_stmt_init($db);
if (mysqli_stmt_prepare($stmt, 'SELECT idusers FROM users WHERE confirmation_token=?')) {
  mysqli_stmt_bind_param($stmt, "s", $confirmation_token);
  mysqli_stmt_execute($stmt);
  mysqli_stmt_bind_result($stmt, $idusers);
  mysqli_stmt_fetch($stmt);
  print_r(mysqli_stmt_error ($stmt));
  mysqli_stmt_close($stmt);
  if( $idusers ){
    $query = "UPDATE users SET confirmation_token='', verified = 'Y' WHERE idusers=$idusers";
    mysqli_query($db, $query);
    $_SESSION['message'][] = 'Email is accepted!';
    header('Location: /');   
    exit; 
  }
  $_SESSION['message'][] = 'Incorrect link';
  header('Location: /');  
}
