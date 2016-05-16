<?php include "includes/session.php"; ?>
<?php

    // Four steps to close a session
    // (i.e) logging out
    
    //1.Find the session
    session_start();
    
//untrack session of logged in user
destroyOnlineStatus();
    //2.Unset all the session varianbles
    $_SESSION = array();
    
    //3.Destroy the session cookie
    if (isset($_COOKIE[session_name()])){
        setcookie(session_name(), '', time()-42000, '/');
    }
    
    //4.destroy the session
    session_destroy();

    
    
    redirect_to("http://localhost/csfello/login.php?logout=1");
?>