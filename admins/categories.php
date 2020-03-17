
<?php

session_start();    

    if( isset($_SESSION['username'])) {
    include "init.php";
    
    
    if (isset($_GET['do'])) {
        $do = $_GET['do'];
    } else {
        $do = 'Mange';
    }

        if ($do == 'Mange') {        
            
            $stmt = $con->prepare("SELECT * FROM catgories");
            $stmt->execute();
            $count_CAT_Items = $stmt->rowcount();

            if( $count_CAT_Items == 0 ){               
                echo "<div class='container'>";
                echo "<div class='alert alert-danger' style='margin: 50px 0; font-size:40px;'>No Data Found</div>";
    
                echo "<a class='btn btn-primary' style='color:#fff;' href='categories.php?do=Add'>+ Add User</a>";  
                echo "</div>";           
            } else {
            
        ?>
            <h2 style="text-align:center; margin:50px 0;">Manage of Categories<h2>   
                     
            <div class='container'>
                <div class="sort_catDiv">
                    <a href="?sort=ASC" class="<?php if($_GET['sort'] == 'ASC') echo 'active';?>">ASC</a>
                    <a href="?sort=DESC" class="<?php if($_GET['sort'] == 'DESC') echo 'active';?>">DESC</a> 
                </div>                  
                <div class="cat_manage">                                                      
                    <?php
                        $sort_type = "ASC";
                        $type_of_sort = array("ASC" , "DESC");

                        if(isset($_GET['sort']) && in_array($_GET['sort'] ,$type_of_sort)) {
                            $sort_type = $_GET['sort'];
                        }

                        $stmt = $con->prepare("SELECT * FROM catgories ORDER BY ordering $sort_type");
                        $stmt->execute();
                        $catgs = $stmt->fetchAll();

                        foreach($catgs as $cat_data) {
                            $cat_GET_ID = $cat_data['catgoryID'];
                            echo "<div class='cat_MAN_div'>";          
                                echo "<div class='buttons_cat_data'>
                                    <button>
                                        <a href='?do=Edit&catgoryID= $cat_GET_ID'>Edit</a>
                                    </button>  
                                    <button>
                                        <a href='?do=Delete&catgoryID= $cat_GET_ID'>Delete</a>
                                    </button>
                                </div>";    
                                echo "<p>cat ID = " . $cat_data['catgoryID'] . "</p>";
                                echo "<p>cat Name = " . $cat_data['Name'] . "</p>";
                                
                                $no_items = array(); 

                                if ($cat_data['Descripe'] == NULL) {
                                    $no_items[0] = "<button class='no_descripe'>No Descripe</button>";
                                } else {
                                    echo "<p>cat Descripe = " . $cat_data['Descripe'] . "</p>";
                                }

                                if($cat_data['ordering'] == 0) {
                                    $no_items[1] = "<button class='no_ordering'>No Ordering</button>";
                                } else {
                                    echo "<p>cat Ordering = " . $cat_data['ordering'] . "</p>";
                                }

                                if($cat_data['visibility'] == 0) {
                                    $no_items[2] = "<button class='no_visibility'>No Visibility</button>";
                                } else {
                                    echo "<p style=''>cat visibility = <button class='success_btn'>visibility</button></p>";
                                }

                                if($cat_data['AllowComments'] == 0) {
                                    $no_items[3] = "<button class='no_comments'>No Comments</button>";
                                } else {
                                    echo "<p style=''>cat Comments = <button class='success_btn'>Comments</button></p>";
                                }

                                if($cat_data['AllowAds'] == 0) {
                                    $no_items[4] = "<button class='no_ads'>No ADS</button>";
                                } else {
                                    echo "<p style=''>cat ADS = <button class='success_btn'>ADS</button></p>";
                                }

                                echo "<div class='empty_item'>";
                                    // this for loop display the buttons which has no data
                                    for($i=0 ; $i <= 4 ; $i++) {
                                        if(!empty($no_items[$i])){
                                            echo $no_items[$i];
                                        }
                                    }
                                echo "</div>";
                            echo "</div>";
                        } 
                    } ?>                
                </div>
            </div>

        <?php
        } 



        elseif ($do == "Add") { ?>
            <!-- ============= Code of HTML ============= -->
            <!-- ============= start form of edit memebers ============= -->
            <div class="container">
                <div class="edit_form">                         
                <h1>Add Category</h1>
                    <form action="?do=Insert" method="POST">
                        <div class="add_cat">
                            <label>Name</label>
                            <input name="cat_name" type="text" required>
                        </div>
                        <div class="add_cat">
                            <label>Description</label>
                            <input name="description" type="text"> 
                        </div>
                        <div class="add_cat">
                            <label>Ordering</label>
                            <input name="ordering" type="text" required>
                        </div>

                        <div class="add_cat">
                            <label for="">Visibility</label>
                            <div>
                                <div>
                                    <input id="vis_yes" value="0" type="radio" name="visible" checked>
                                    <label style="margin:0; position:absolute; font-size: 20px;" for="vis_yes">YES</label>
                                </div>
                                <div>
                                    <input id="vis_No" value="1" type="radio" name="visible">
                                    <label style="margin:0; position:absolute; font-size: 20px;" for="vis_No">NO</label>
                                </div>
                            </div>                            
                        </div>

                        <div class="add_cat">
                            <label for="">Allow Commenting</label>
                            <div>
                                <div>
                                    <input id="comment_yes" value="0" type="radio" name="commenting" checked>
                                    <label style="margin:0; position:absolute; font-size: 20px;" for="comment_yes">YES</label>
                                </div>
                                <div>
                                    <input id="comment_No" value="1" type="radio" name="commenting">
                                    <label style="margin:0; position:absolute; font-size: 20px;" for="comment_No">NO</label>
                                </div>
                            </div>                            
                        </div>

                        <div class="add_cat">
                            <label for="">Allow Ads</label>
                            <div>
                                <div>
                                    <input id="ads_yes" value="0" type="radio" name="ADS" checked>
                                    <label style="margin:0; position:absolute; font-size: 20px;" for="ads_yes">YES</label>
                                </div>
                                <div>
                                    <input id="ads_No" value="1" type="radio" name="ADS">
                                    <label style="margin:0; position:absolute; font-size: 20px;" for="ads_No">NO</label>
                                </div>
                            </div>                            
                        </div>

                        <input type="submit" class="save_btn" value="Save">
                    </form>
                </div>
            </div>
            <?php       
        } 
        


        
        elseif($do == 'Insert') {
            if($_SERVER['REQUEST_METHOD'] == "POST") {                    
                // the data we get it from the form above
                $cat_name = $_POST['cat_name'];
                $description = $_POST['description'];
                $ordering = $_POST['ordering'];
                $visible = $_POST['visible'];
                $commenting = $_POST['commenting'];
                $ADS = $_POST['ADS'];

                // check if the name of this category is in the database or not 
                $check_cat = checkINdataBase('Name' , 'catgories' , $cat_name);
                echo $check_cat;

                 if($check_cat == 1) {
                    $theMsg = "Sorry this username is exit";
                    redirect( $theMsg , 'danger' , "Back");
                } else {

                    $stmt = $con->prepare("INSERT INTO catgories(Name, Descripe , ordering , visibility ,AllowComments, AllowAds) VALUES(:ZName , :ZDescripe , :Zordering , :Zvisibility , :Zcomments, :Zads)");                        

                    $stmt->execute(array(
                        "ZName" => $cat_name,
                        "ZDescripe" => $description,
                        "Zordering" => $ordering,
                        "Zvisibility" => $visible,
                        "Zcomments" => $commenting,
                        "Zads" => $ADS
                    ));     
                }               
            ?>

                <!-- success message -->
                <div class="container">
                    <?php
                        $mes = 'Success of Inserting CAT';
                        redirect( $mes , 'success' , 'categories.php?do=Mange');
                    ?>
                </div>

            <?php       
            } else {
                header('Location:dashboard.php');
            }                 
        }




        elseif ($do == "Edit") {

            // echo "EDIT PAGE";

            if(isset($_SESSION['username']) && isset($_GET['catgoryID']) && is_numeric($_GET['catgoryID'])) {
                $catgoryEidtID = $_GET['catgoryID'];
                // this for select all items in record by it id
                $stmt = $con->prepare("SELECT * FROM catgories WHERE catgoryID = ?");
                $stmt->execute(array($catgoryEidtID));
                $row = $stmt->fetch();

                if($catgoryEidtID == $row['catgoryID']) {
                ?>
                 <!-- ============= Code of HTML ============= -->
                 <!-- ============= start form of edit memebers ============= -->

                <div class="container">
                    <div class="edit_form">                         
                    <h1>Edit Members</h1>

                    <form action="?do=Update" method="POST">
                        <input type="text" name= "cat_ID" style="display:none;" value="<?php echo $row['catgoryID'];?>">
                        <div class="add_cat">
                            <label>Name</label>
                            <input name="cat_name" type="text" value="<?php echo $row['Name']?>">
                        </div>
                        <div class="add_cat">
                            <label>Description</label>
                            <input name="description" type="text" value="<?php echo $row['Descripe']?>"> 
                        </div>
                        <div class="add_cat">
                            <label>Ordering</label>
                            <input name="ordering" type="text" value="<?php echo $row['ordering']?>">
                        </div>

                        <div class="add_cat">
                            <label for="">Visibility</label>
                            <div>
                                <div>
                                    <input id="vis_yes" value="0" type="radio" name="visible" <?php if($row['visibility'] == 0 ) echo 'checked'?>>
                                    <label style="margin:0; position:absolute; font-size: 20px;" for="vis_yes">YES</label>
                                </div>
                                <div>
                                    <input id="vis_No" value="1" type="radio" name="visible" <?php if($row['visibility'] == 1 ) echo 'checked'?>>
                                    <label style="margin:0; position:absolute; font-size: 20px;" for="vis_No">NO</label>
                                </div>
                            </div>                            
                        </div>

                        <div class="add_cat">
                            <label for="">Allow Commenting</label>
                            <div>
                                <div>
                                    <input id="comment_yes" value="0" type="radio" name="commenting" <?php if($row['AllowComments'] == 0 ) echo 'checked'?>>
                                    <label style="margin:0; position:absolute; font-size: 20px;" for="comment_yes">YES</label>
                                </div>
                                <div>
                                    <input id="comment_No" value="1" type="radio" name="commenting" <?php if($row['AllowComments'] == 1 ) echo 'checked'?>>
                                    <label style="margin:0; position:absolute; font-size: 20px;" for="comment_No">NO</label>
                                </div>
                            </div>                            
                        </div>

                        <div class="add_cat">
                            <label for="">Allow Ads</label>
                            <div>
                                <div>
                                    <input id="ads_yes" value="0" type="radio" name="ADS" <?php if($row['AllowAds'] == 0 ) echo 'checked'?>>
                                    <label style="margin:0; position:absolute; font-size: 20px;" for="ads_yes">YES</label>
                                </div>
                                <div>
                                    <input id="ads_No" value="1" type="radio" name="ADS" <?php if($row['AllowAds'] == 1 ) echo 'checked'?>>
                                    <label style="margin:0; position:absolute; font-size: 20px;" for="ads_No">NO</label>
                                </div>
                            </div>                            
                        </div>

                        <input type="submit" class="save_btn" value="Update">
                    </form>
                    </div>
                </div>
             <?php } else { 
                    $erroe_MSG = "There is Invalid ID>";
                    redirect( $erroe_MSG , 'danger');
                } 
            } else {
                $erroe_MSG = "There is Invalid ID";
                redirect( $erroe_MSG , 'danger' , "Main" ,6);
            } 
            // ============= End form of edit memebers =============            
        }

        





        elseif ($do == "Update") {
            if($_SERVER['REQUEST_METHOD'] == "POST") {                 
                // This to get the data from edit page by the post funtion
                $cat_id = $_POST['cat_ID'];

                $cat_name = $_POST['cat_name'];     // user id value geted by hidden 
                $cat_description = $_POST['description'];
                $cat_ordering = $_POST['ordering'];
                $cat_visible = $_POST['visible'];
                $cat_commenting = $_POST['commenting'];
                $cat_ADS = $_POST['ADS'];
                    
                // ############# this code to select the id from the database
                $stmt = $con->prepare("SELECT * FROM catgories WHERE catgoryID = ? LIMIT 1");
                $stmt->execute(array($cat_id));
                $row = $stmt->fetch();
                // =============

                // this for update the data into the database
                $stmt=$con->prepare("UPDATE catgories 
                                     SET Name = ? , 
                                     Descripe = ? , 
                                     ordering = ? , 
                                     visibility = ? ,
                                     AllowComments = ? , 
                                     AllowAds = ?
                                     WHERE catgoryID = ?");                      

                // I must pass the variable ($id) to change data in database and avoid errors
                $stmt->execute(array($cat_name,$cat_description,$cat_ordering,$cat_visible,$cat_commenting,$cat_ADS , $cat_id));
                
                // success message
                $theMsg = "The Updates are saved";
                redirect( $theMsg , 'success' , "BACK");
            } else {
                header("Location:index.php");
            }            
        }  
        
        
        
        
        
        elseif ($do == "Delete") {

            if(isset($_GET['catgoryID']) && is_numeric($_GET['catgoryID'])) {
                
                $CAT_DEL_ID = $_GET['catgoryID'];                
                $stmt=$con->prepare('DELETE FROM catgories WHERE catgoryID = :DEL_CAT_id');
                $stmt->bindParam(':DEL_CAT_id' , $CAT_DEL_ID);
                $stmt->execute();

                $mes_del = "<div class='alert alert-success' style='font-size:20px; margin-top:40px; font-weight:700;'>
                    1 record deleted.</div>";
                redirect( $mes_del , 'BACK');

            }
            
        } else {
            header('Location:dashboard.php');
        }








    } else {
        header('Location:index.php');
    }