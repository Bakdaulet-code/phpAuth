<?php
$email = '';
$pass1 = '';
$pass2 = '';

if( $_SERVER['REQUEST_METHOD'] == 'POST' ){
$email = filter_input(
  INPUT_POST,
  'email',
  FILTER_VALIDATE_EMAIL 
);

$pass= $_POST['pass'] ?? '';

$_SESSION['message'] = [];
if( !$email ) {
  $_SESSION['message'][] = 'Type an email for logging in';
  header('Location: /');
  exit;
}
if( !$pass ) {
  $_SESSION['message'][] = 'Type an email for logging in';
  header('Location: /');
  exit;
}

$query = "SELECT idusers, email, pass, verified FROM users WHERE email=?";
if ($stmt = mysqli_prepare($db, $query)) {

  mysqli_stmt_bind_param($stmt, "s", $email);
  mysqli_stmt_execute($stmt);
  mysqli_stmt_bind_result($stmt, $idusers, $emailDB, $passDB, $verifiedDB);
  mysqli_stmt_fetch($stmt);

  if( $verifiedDB == 'N' ){
    $_SESSION['message'][] = 'Click the link that sent to your email!';
    header('Location: /');
    exit;
  }

  if( password_verify($pass, $passDB)  ){
    $_SESSION['username'] = $email;
    header('Location: /');
    exit;    
  }
  $_SESSION['message'][] = 'Incorrect password';
  header('Location: /');
  exit; 
}

}