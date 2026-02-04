<?php
session_start();

ini_set('session.cookie_httponly',1);
ini_set('session.cookie_secure',0); 
ini_set('session.use_only_cookies',1);

if(!isset($_SESSION['CREATED'])){
    $_SESSION['CREATED'] = time();
}else if(time() - $_SESSION['CREATED'] > 1800){
    session_regenerate_id(true);
    $_SESSION['CREATED'] = time();
}

if(!isset($_SESSION['LAST_ACTIVITY'])){
    $_SESSION['LAST_ACTIVITY']=time();
}else if(time() - $_SESSION['LAST_ACTIVITY'] > 900){
    session_unset();
    session_destroy();
    header("Location:index.php");
    exit;
}
$_SESSION['LAST_ACTIVITY']=time();
?>
