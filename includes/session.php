<?php session_start();
    
    function logged_in() {
        return isset($_SESSION['userID']);
    }
    
    function confirm_logged_in(){
       if (!logged_in()){
       session_write_close();
           header("Location: http://localhost/csfello/login.php");
           exit();
       }
    }

function redirect_to($location){
    if ($location != NULL){
    header("Location: {$location}");
    exit;
    }
}

function trackOnlineUsers(){
    global $connection;
    if (isset($_SESSION['userID'])){
        $userID = $_SESSION['userID'];
        $query = "INSERT INTO online_users (user_id, online_status) VALUES ($userID, 'ON')";
        $result = mysqli_query($connection, $query);
        if (!$result){
            die("Could not INSERT INTO online_users" . mysqli_error());
        }        
    }
}

function destroyOnlineStatus(){
    $connection = mysqli_connect("localhost", "root", "", "csfello");

    if (!$connection){
        echo "Connection to db NOT successful!" . mysqli_error();
    }
    
    if (isset($_SESSION['userID'])){
        $userID = $_SESSION['userID'];
        $query = "DELETE FROM online_users WHERE user_id = {$userID} LIMIT 1";
        $result = mysqli_query($connection, $query);
        if (!$result){
            die("Could not DELETE online status" . mysqli_error());
        }        
    }
}
?>