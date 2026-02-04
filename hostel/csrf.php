<?php
if(empty($_SESSION['token'])){
    $_SESSION['token']=bin2hex(random_bytes(32));
}

function csrf(){
    echo '<input type="hidden" name="token" value="'.$_SESSION['token'].'">';
}

function verify_csrf(){
    if(!isset($_POST['token']) || $_POST['token'] !== $_SESSION['token']){
        die("Security Error ❌ Possible CSRF Attack Blocked");
    }
}
?>
