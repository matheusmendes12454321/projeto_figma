<?php
function logout(){
    session_start();
    $_SESSION = array();
    
    session_destroy();
    
    header('Location: ../Paginas/index.html'); 
    exit;
}

if(isset($_GET['action']) && $_GET['action'] == 'logout') {
    logout();
}
?>