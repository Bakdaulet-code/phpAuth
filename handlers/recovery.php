<?php

if( $_SERVER['REQUEST_METHOD'] == 'POST' ){
  $email = filter_input(
    INPUT_POST,
    'email',
    FILTER_VALIDATE_EMAIL 
  );

  $query = "SELECT idusers, email, pass, verified FROM users WHERE email=?";
  if ($stmt = mysqli_prepare($db, $query)) {
  
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $idusers, $emailDB, $passDB, $verifiedDB);
    mysqli_stmt_fetch($stmt);
 
    if( !$emailDB ){
      $_SESSION['message'][] = 'Recovery not available account';
      header('Location: /');
      exit;
    }

    if( $verifiedDB == 'N' ){
      $_SESSION['message'][] = 'Click the link that sent to your email!';
      header('Location: /');
      exit;
    }

    $recovery_token = bin2hex(random_bytes(40));
    $_SESSION['recovery_token'] = $recovery_token;
    $_SESSION['email'] = $emailDB;

    $subject = "Восстановление пароля {$_SERVER['SERVER_NAME']}";
    $msg = "If this is not your attempt to reset your password, please ignore this message. If you are trying to recover your password, click on <a href=\"http://{$_SERVER['SERVER_NAME']}?recovery_token=" . $recovery_token . "\">link</a> to set a new password";
    $headers = "From: no-reply@{$_SERVER['SERVER_NAME']}";
    mail($to, $subject, $msg, $headers);

    $_SESSION['message'][] = 'A link to reset your password has been sent to your email';
    header('Location: /');
    exit; 
  }
}