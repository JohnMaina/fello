<?php 
include "includes/session.php"; ?>
<?php
//check if user is logged in
//confirm_logged_in();
if (logged_in()){
    redirect_to("index.php");
}
?>
<?php
include "includes/functions.php";
global $connection;

if (isset($_POST['submit'])){
    $username = $_POST['form-username'];
    $password = $_POST['form-password'];
    
    $username = mysqli_real_escape_string($connection, $username );
    $username = strtolower($username);
    $password = mysqli_real_escape_string($connection, $password );
    
    
    $query = "SELECT * FROM users WHERE username = '{$username}' and password = '{$password}' LIMIT 1";
    $result = mysqli_query($connection, $query);
 
    if (!$result){
        die ("Could not connect to the database" . mysqli_error($connection));
    }
    
        $row = mysqli_fetch_assoc($result);
        $username = $row['username'];
        $userID = $row['id'];
        $dbusername = strtolower($username);
        $dbpassword = $row['password'];
    
    if (strcasecmp($username, $dbusername) == 0 && $password == $dbpassword){
        //login successful, set session
        $_SESSION['userID'] = $userID;
        
        trackOnlineUsers();
        $url = "http://localhost/csfello/index.php";
        redirect_to($url);
        
    } else {
        //login not successful
        $errorMessage = "Login was not successful! Please try again.";
        $errorMessage .= " Make sure you use your first name as Username and phone number as Password.";
    }
    
        if (isset($_GET['logout']) && $_GET['logout'] == 1){
            $logout_message = "You are now logged out.<br /><b>Please log in to continue.</b>";
            $username = "";
            $username = "";
        }
}

?>
<!DOCTYPE html>
<html lang="en">

    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Fellowship Constitutional Review</title>

        <!-- CSS -->
        <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Roboto:400,100,300,500">
        <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="assets/font-awesome/css/font-awesome.min.css">
		<link rel="stylesheet" href="assets/css/form-elements.css">
        <link rel="stylesheet" href="assets/css/style.css">

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->

        <!-- Favicon and touch icons -->
        <link rel="shortcut icon" href="assets/ico/favicon.png">
        <link rel="apple-touch-icon-precomposed" sizes="144x144" href="assets/ico/apple-touch-icon-144-precomposed.png">
        <link rel="apple-touch-icon-precomposed" sizes="114x114" href="assets/ico/apple-touch-icon-114-precomposed.png">
        <link rel="apple-touch-icon-precomposed" sizes="72x72" href="assets/ico/apple-touch-icon-72-precomposed.png">
        <link rel="apple-touch-icon-precomposed" href="assets/ico/apple-touch-icon-57-precomposed.png">

    </head>

    <body>

        <!-- Top content -->
        <div class="top-content">
        	
            <div class="inner-bg">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-8 col-sm-offset-2 text">
                           <?php
                            if (isset($_POST['submit']) && isset($errorMessage)){
                                echo "<p class=\"bg-danger\">". $errorMessage ."</p>";
                            }
                            ?>
                            <h1><strong>CS fello</strong> Constitutional Review</h1>
                            <div class="description">
                            	<p>
	                            	Use your first name (or popular nickname) as your username and your phone number as Password
                            	</p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6 col-sm-offset-3 form-box">
                        	<div class="form-top">
                        		<div class="form-top-left">
                        			<h3>Enter your username and password:</h3>
                        			<p>This is a simple web app designed to help us compile the constitution.</p>
                        		</div>
                        		<div class="form-top-right">
                        			<i class="fa fa-key"></i>
                        		</div>
                            </div>
                            <div class="form-bottom">
			                    <form role="form" action="" method="post" class="login-form">
			                    	<div class="form-group">
			                    		<label class="sr-only" for="form-username">Username</label>
			                        	<input type="text" name="form-username" placeholder="Username..." class="form-username form-control" id="form-username">
			                        </div>
			                        <div class="form-group">
			                        	<label class="sr-only" for="form-password">Password</label>
			                        	<input type="password" name="form-password" placeholder="Password..." class="form-password form-control" id="form-password">
			                        </div>
			                        <button type="submit" name="submit" class="btn">Log in!</button>
			                    </form>
		                    </div>
                        </div>
                    </div>

                </div>
            </div>
            
        </div>


        <!-- Javascript -->
        <script src="assets/js/jquery-1.11.1.min.js"></script>
        <script src="assets/bootstrap/js/bootstrap.min.js"></script>
        <script src="assets/js/jquery.backstretch.min.js"></script>
        <script src="assets/js/scripts.js"></script>
        
        <!--[if lt IE 10]>
            <script src="assets/js/placeholder.js"></script>
        <![endif]-->

    </body>

</html>