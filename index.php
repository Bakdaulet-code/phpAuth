<?php

ob_start();

session_start();

include "config_db.php";

if( !empty($_SESSION['message']) ){
  foreach($_SESSION['message'] as $value){
    echo <<<MESSAGE
<div>{$value}</div>   
MESSAGE;
  }
  unset($_SESSION['message']);
}

if( !empty($confirmation_token = $_GET['confirmation_token']) ){
  include "handlers/confirmation_token.php";  
}

if( isset( $_GET['recovery_token'])) {
  include "handlers/recovery_token.php"; 
}

if( isset($_GET['logout']) ){
  include "handlers/logout.php";  
}

if($_SESSION['username']){
  include "views/index.php";

 } elseif( !isset($_GET['recovery']) && !isset($_GET['signup']) ){ 

  include "handlers/login.php";
  include "views/login.php";
}
 elseif( isset($_GET['recovery']) ){

  include "handlers/recovery.php";
  include "views/recovery.php";
}
 elseif( isset($_GET['signup']) ){

  include "handlers/signup.php";
  include "views/signup.php";
}
?>
