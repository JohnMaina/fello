<?php 
    global $connection;
    	if (isset($_POST['create_comment'])) {
        $content = mysqli_real_escape_string($connection, $_POST['comment_content']);
        
        date_default_timezone_set('Africa/Nairobi');

        $time = date("Y-m-d H:i:s");
            
        $userID = $_SESSION['userID'];
        
        $author = getUserName($userID);

        if (isset($_GET['section_id']) || isset($_SESSION['section_id'])){
        //$section_id = $_GET['section_id'];
        $section_id = $_SESSION['section_id'];

        $query = "INSERT INTO comments (category_id, comment_author, comment_time, comment_content) ";
        $query .= "VALUES ({$section_id}, '{$author}', '{$time}', '{$content}')";

        $result = mysqli_query($connection, $query);
        if (!$result){
            die ("Could not insert comments into the Database" . mysqli_error($connection));
        }
      } else {
            echo "cant get the section id";
        }
        $current_url = "http://localhost/csfello/index.php?section_id={$section_id}";
        redirect_to($current_url);
	}
?>
        <div class="row">

            <div class="col-md-3">
                <p class="lead">Constitution Sections</p>
                <div class="list-group">
                <!-- here we are getting the menu items on the left. Sections -->
                <?php getSections(); ?>
                
                </div>
            </div>

            <div class="col-md-9">

                <div class="thumbnail">
                    
                    <div class="caption-full">
                       <?php 
                        if (isset($_GET['section_id'])){
                            $section_id = $_GET['section_id'];
                            displayConstitutionContent($section_id); 
                        } else {
                            echo "<h4> Please select a section to contribute. </h4>";
                        }
                        ?>
                    </div>
                </div>

                <div class="well">
                    <?php
                    //get comments from db for this section
                    getCommentsFromDb();
                    
                    ?>   
                    
                    <?php
                    
                    if (isset($_GET['section_id'])){
                        
                    ?>
                    <form class="form-horizontal" role="form" method="post" action="index.php">
                      <div class="form-group">
                       <?php
                           $userID = $_SESSION['userID'];
                           $author = getUserName($userID);
                        ?>
                        <label for="exampleInputPassword1">What do you think about this section 
                        <?php 
                            if (isset($_GET['section_id'])){
                                echo $author . "?"; 
                            }
                            
                        ?>
                        </label>
                        <textarea class="form-control" rows="5" id="contribution" name="comment_content" placeholder="Your thoughts?"></textarea>
                      </div>
                    <div class="form-group">
                           <button type="submit" name="create_comment" class="btn btn-primary">Submit</button>
                    </div>
                    </form> 
                    <?php
                    }
                    ?>
                    <hr>              
                </div>

            </div>

        </div>