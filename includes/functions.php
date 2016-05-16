<?php //include "session.php"; ?>
<?php include "db.php"; ?>
<?php

function getSections(){
    global $connection;
    $query = "SELECT * FROM categories";
    $result = mysqli_query($connection, $query);
    if (!$result){
        die("Could not read from categories" . mysqli_error());
    }
    
    while ($row = mysqli_fetch_assoc($result)){
        $id = $row['category_id'];
        $category_name = $row["category_name"];
        if (isset($_GET['section_id'])){
            $selected_id = $_GET['section_id'];
            $_SESSION['section_id'] = $selected_id;
            
            $firstpart = "<a href=\"http://localhost/csfello/index.php?section_id=$id\"";
                
            if ($id == $selected_id){
               $secondpart = " class=\"list-group-item active\">";
            }
            else{
                $secondpart = " class=\"list-group-item\">";
            }
            
            $thirdpart =   $category_name . "</a>";
            
            echo $firstpart . $secondpart . $thirdpart;
                        
            
        } else {
            echo "<a href=\"http://localhost/csfello/index.php?section_id=$id\" class=\"list-group-item\">" . $category_name . "</a>";
        }      
    }
}



function getUserName($session_id){
        //get logged in author
        global $connection;
    
        $get_author = "SELECT * FROM users where id = {$session_id} LIMIT 1";
        $get_author_result = mysqli_query($connection, $get_author);
        
        if (!$get_author_result){
            die ("Could not get the author" . mysqli_error());
        }
        
        while ($row = mysqli_fetch_assoc($get_author_result)){
            $author = $row["username"];
            return $author;
        }
        
        
    return $author;
        
}

function getMenu(){
    global $connection;
    $query = "SELECT * FROM menus";
    $result = mysqli_query($connection, $query);
    if (!$result){
        die("Could not read from menus" . mysqli_error());
    }
    
    $loggedInUser = getUsername($_SESSION['userID']);

    echo "<li><a href=\"#\">Hi " . $loggedInUser . " </a></li>";
    while ($row = mysqli_fetch_assoc($result)){
        $menu_name = $row['menu_name'];
        echo "<li><a href=\"http://localhost/csfello/logout.php\">". $menu_name . "</a></li>";
    }   
}


                        
function displayConstitutionContent($section_id){
    global $connection;

        $query = "SELECT * FROM categories where category_id = {$section_id} LIMIT 1";
        $result = mysqli_query($connection, $query);
        if (!$result){
            die("Could not read the sections" . mysqli_error($connection));
        }

        $row = mysqli_fetch_assoc($result);
        $section_name = $row['category_name'];
        $section_description = $row['description'];

        echo "<h4><a href=\"#\">" . $section_name . "</a></h4>";
        echo "<p><pre>" . $section_description . "</pre></p>";
} //end function displayConstitutionContent()


//get comments from the database
function getCommentsFromDb(){
    global $connection;
    if (isset($_GET['section_id'])){
        $section_id = $_GET['section_id'];

        $query = "SELECT * FROM comments WHERE category_id = {$section_id}";
        $result = mysqli_query($connection, $query);
        if (!$result){
            die ("Could not read from table comments" . mysqli_error());
        }
            while ($row = mysqli_fetch_assoc($result)){
                $comment_date = $row['comment_time'];
                $comment_content = $row['comment_content'];
                $comment_author = $row['comment_author'];

                echo "<div class=\"row\"> ";
                echo "<div class=\"col-md-12\"> ";
                echo "Posted By: " . "<strong>" . $comment_author . "</strong> ";
                echo "<span class=\"pull-right\">" . $comment_date . "</span>";
                echo "<p>" . $comment_content . "</p>";
                echo "</div>";
                echo "</div><hr>";
          }
        }
}






?>