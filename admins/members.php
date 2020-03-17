<?php
    session_start();
    if(isset($_SESSION['username'])) {
        include 'init.php';

        if(isset($_GET['do'])) {
            $do = $_GET['do'];
        } else {
            $do = 'Manage';
        }

        if($do == 'Manage') { 

            $stmt = $con->prepare('SELECT * FROM users WHERE GroupID = 0');
            $stmt->execute();
            $USERS_count = $stmt->rowcount();

            if($USERS_count == 0 ) {
                echo "<div class='container'>";
                echo "<div class='alert alert-danger' style='margin: 50px 0; font-size:40px;'>No Data Found</div>";      
                echo "<a class='btn btn-primary' style='color:#fff;' href='members.php?do=Add'>+ Add User</a>";
                echo "</div>";                
            } else {
                if($_SERVER['REQUEST_METHOD'] == 'GET') { 
                    ?>
                <div class="container manage_page">
                    <h1 style="text-align:center; margin: 40px 0;">Mangae Users</h1>
                    <table class="table">
                        <thead>
                            <tr>
                            <th scope="col">#ID</th>
                            <th scope="col">Username</th>
                            <th scope="col">Email</th>
                            <th scope="col">FullName</th>
                            <th scope="col">Registerd Date</th>
                            <th scope="col">Control</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $stmt = $con->prepare('SELECT * FROM users WHERE GroupID !=1');
                            $stmt->execute();
                            $rows = $stmt->fetchAll();

                            foreach($rows as $row_data) {
                                echo "<tr>";
                                    echo "<th>" .  $row_data['userID'] . "</th>";
                                    echo "<td>" .  $row_data['username'] . "</td>";
                                    echo "<td>" .  $row_data['email'] . "</td>";
                                    echo "<td>" .  $row_data['FullName'] . "</td>";
                                    echo "<td>" .  $row_data['Date'] . "</td>";    // this for display the date of register of the user
                                    echo "<td>
                                        <a href= 'members.php?do=Edit&userID=" . $row_data['userID'] . "' class='btn btn-success'>Edit</a>
                                        <a href= 'members.php?do=Delete&userID=" . $row_data['userID'] . "' class='btn btn-danger confirm'>Delete</a>";
                                        
                                        if($row_data['RegsStatus'] == 0) {     
                                        echo "<a href= 'members.php?do=Activate&userID=" . $row_data['userID'] . "' class='btn btn-info'>Activiate</a>";
                                        }
                                    echo "</td>";                                                
                                echo "</tr>";
                            }                            
                    } else {
                        $erroe_MSG = "Error!!! You can't Enter this page";
                        redirect( $erroe_MSG , 'danger' , 6);
                    }
                ?>
                    </tbody>
                    </table>
                    <a class="btn btn-primary" style="color:#fff;" href="members.php?do=Add">+ Add User</a>
                </div>               

            <?php
                
            } 
        }                            

        
        elseif ($do == 'Edit') {              
            if(isset($_SESSION['username']) && isset($_GET['userID']) && is_numeric($_GET['userID'])) {
                $userEidtID = $_GET['userID'];
                // this for select all items in record by it id
                $stmt = $con->prepare("SELECT * FROM users WHERE userID = ? LIMIT 1");
                $stmt->execute(array($userEidtID));
                $row = $stmt->fetch();

                if($userEidtID == $row['userID']) {
                ?>
                <!-- ============= Code of HTML ============= -->
                <!-- ============= start form of edit memebers ============= -->
                <div class="container">
                    <div class="edit_form">                         
                    <h1>Edit Members</h1>
                        <form action="?do=Update" method="POST">
                            <div class="edit_data">
                                <input type="text" name= "userid" style="display:none;" value="<?php echo $row['userID'];?>">
                                <label>Username</label>
                                <input name="username" type="text" value="<?php echo $row['username']; ?>">
                            </div>
                            <div class="edit_data">
                                <label>Password</label>
                                <input name="password" type="password">
                            </div>
                            <div class="edit_data">
                                <label>Email</label>
                                <input name="email" type="text" value="<?php echo $row['email']; ?>">
                            </div>
                            <div class="edit_data">
                                <label>Full Name</label>
                                <input name="full_name" type="text" value="<?php echo $row['FullName']; ?>">
                            </div>
                            <input type="submit" class="save_btn" value="Save">
                        </form>
                    </div>
                </div>
            <?php } else {
                    $erroe_MSG = "There is Invalid ID";
                    redirect( $erroe_MSG , 'danger');
                } 
            } else {
                $erroe_MSG = "There is Invalid ID";
                redirect( $erroe_MSG , 'danger' , "Main" , 6);
            } 
            // ============= End form of edit memebers ============= 
        }                    


         elseif ($do == 'Update') {          
            if($_SERVER['REQUEST_METHOD'] == "POST") {                 
                // This to get the data from edit page by the post funtion
                $id = $_POST['userid'];     // user id value geted by hidden 
                $user = $_POST['username'];
                $email = $_POST['email'];
                $full_name = $_POST['full_name'];

                if($_POST['password'] == '') {    

                    // =============
                    // ############# this code to select the id from the database
                    $stmt = $con->prepare("SELECT * FROM users WHERE userID = ? LIMIT 1");
                    $stmt->execute(array($id));
                    $row = $stmt->fetch();
                    // =============

                    // ******* this varable to assign the the old pass to varaible ($oldPass)
                    $oldPass = $row['password'];
                    $Newpass = $oldPass;                    
                } else {
                    $Newpass = $_POST['password'];
                }

                $formErrors = array();                    
                echo "<div class='container main_Errors'>";
                if(empty($user)) {
                    $formErrors[] = "username is empty";
                } 
                
                if(empty($full_name)) {
                    $formErrors[] = "full name is empty";
                }

                if(empty($email)) {
                    $formErrors[] = "email is empty";
                }

                foreach($formErrors as $err) {
                    echo "<div class='Error_MESG alert alert-danger' style='font-size:20px; margin-top:40px;font-weight:700;' >" . $err . "</div>";
                }

                if(empty($formErrors)) {
                    // this for update the data into the database
                    $stmt=$con->prepare("UPDATE users SET username = ?,password = ?,email = ?,FullName = ? WHERE userID = ?");                        

                    // I must pass the variable ($id) to change data in database and avoid errors
                    $stmt->execute(array($user ,$Newpass , $email , $full_name , $id));
                    
                    // success message
                    $theMsg = "The Updates are saved";
                    redirect( $theMsg , 'success' , "BACK");
                }
            }            
            
            else {
                header("Location:index.php");
            }
            echo "</div>";            
        }



        
        elseif ($do == 'Add') { ?>
            <!-- ============= Code of HTML ============= -->
            <!-- ============= start form of edit memebers ============= -->
            <div class="container">
                <div class="edit_form">                         
                    <h1>Add Member</h1>
                    <form action="?do=Insert" method="POST">
                        <div class="edit_data">
                            <label>Username</label>
                            <input name="username" type="text" required>
                        </div>
                        <div class="edit_data">
                            <label>Password</label>
                            <input name="password" type="password" class="password_content" required> 
                            <!-- ----------- icon of show password -->
                            <i class="show-pass far fa-eye"></i>
                        </div>
                        <div class="edit_data">
                            <label>Email</label>
                            <input name="email" type="text" required>
                        </div>
                        <div class="edit_data">
                            <label>Full Name</label>
                            <input name="full_name" type="text" required>
                        </div>
                        <input type="submit" class="save_btn" value="Save">
                    </form>
                </div>
            </div>
            <?php       
        }  


                     
    
        elseif($do == 'Insert') {
            if($_SERVER['REQUEST_METHOD'] == "POST") {               
                $user = $_POST['username'];
                $email = $_POST['email'];
                $full_name = $_POST['full_name'];
                $password = $_POST['password'];

                // echo $full_name . $user . $email . $password;

                $check_user = checkItem('username' , 'users' , $user);

                if($check_user == 1) {
                    $theMsg = "Sorry this username is exit";
                    redirect( $theMsg , 'danger');
                } else {

                    // RegsStatus I set it (1) as a default because the admin who add the user
                    // (1) on RegsStatus means that this user is active
                    $stmt = $con->prepare("INSERT INTO users(username , password , email , FullName , RegsStatus, Date) 
                    VALUES(:Zuser , :Zpass , :Zemail , :Zfullname , 1, now())");

                    $stmt->execute(array(
                        "Zuser" => $user,
                        "Zpass" => $password,
                        "Zemail" => $email,
                        "Zfullname" => $full_name
                    ));     
                }                
            ?>

                <!-- success message -->
                    <?php
                        $mes = 'Success of Inserting member';
                        redirect( $mes , 'success' , 'members.php');
                    ?>
                </div>
            <?php       
            } else {
                header('Location:index.php');
            }                 
        }          


                                                        
        
        elseif($do == 'Delete') {
            if(isset($_GET['userID']) && is_numeric($_GET['userID'])) {
                $userdeID = $_GET['userID'];
                
                $stmt = $con->prepare("DELETE FROM users WHERE userID = :DELuserID");
                $stmt->bindParam(":DELuserID" , $userdeID);
                $stmt->execute(); 
                
                $mes = "1 record deleted.";
                redirect( $mes , 'danger', 'members');
            }
        } 
        
        
        
        elseif($do == 'Activate') {

            $userACID = $_GET['userID'];    

            $stmt = $con->prepare("UPDATE users SET RegsStatus = 1 WHERE userID = ?");
            $stmt->execute(array($userACID)); 

            $mes = "1 record Activated.";
            redirect( $mes , 'success', 'members');
        } 



        // this is for show the data of all admins in the website 
        elseif($do == 'Admins') {
            $GroupIDadmin = $_GET['GroupID'];    
            echo "<h1 style='text-align:center; padding:50px 0;'>Totla Admins</h1>";
                ?>
                
                <div class="container">
                    <table class="table">
                        <thead>
                            <tr>
                            <th scope="col">#ID</th>
                            <th scope="col">Username</th>
                            <th scope="col">Email</th>
                            <th scope="col">FullName</th>
                            <th scope="col">Registerd Date</th>
                            <th scope="col">Control</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $stmt = $con->prepare('SELECT * FROM users WHERE GroupID =' . $GroupIDadmin);
                            $stmt->execute();
                            $row = $stmt->fetchAll();

                            foreach($row as $admin_Member) {
                                echo "<tr>";
                                    echo "<th>" .  $admin_Member['userID'] . "</th>";
                                    echo "<td>" .  $admin_Member['username'] . "</td>";
                                    echo "<td>" .  $admin_Member['email'] . "</td>";
                                    echo "<td>" .  $admin_Member['FullName'] . "</td>";
                                    echo "<td>" .  $admin_Member['Date'] . "</td>";    // this for display the date of register of the user
                                    echo "<td>
                                        <a href= 'members.php?do=Edit&userID=" . $admin_Member['userID'] . "' class='btn btn-success'>Edit</a>
                                        <a href= 'members.php?do=Delete&userID=" . $admin_Member['userID'] . "' class='btn btn-danger confirm'>Delete</a>";
                                    echo "</td>";
                                                
                                echo "</tr>";
                            }                            
                            ?>
                        </tbody>
                        </table>
                        <a class='btn btn-primary' style='color:#fff;' href='members.php?do=Add_admin'>+ Add User</a>
                    </div>
                    <?php
        }  

        elseif ($do == 'Add_admin') { ?>
            <!-- ============= Code of HTML ============= -->
            <!-- ============= start form of edit memebers ============= -->
            <div class="container">
                <div class="edit_form">                         
                    <h1>Add Admin</h1>
                    <form action="?do=Admin_Insert" method="POST">
                        <div class="edit_data">
                            <label>Admin Name</label>
                            <input name="Admin_name" type="text" required>
                        </div>
                        <div class="edit_data">
                            <label>Password</label>
                            <input name="admin_password" type="password" class="password_content" required> 
                            <!-- ----------- icon of show password -->
                            <i class="show-pass far fa-eye"></i>
                        </div>
                        <div class="edit_data">
                            <label>Email</label>
                            <input name="admin_email" type="text" required>
                        </div>
                        <div class="edit_data">
                            <label>Full Name</label>
                            <input name="admin_full_name" type="text" required>
                        </div>
                        <input type="submit" class="save_btn" value="Save">
                    </form>
                </div>
            </div>
            <?php 
        }


        elseif($do == 'Admin_Insert'){
            if($_SERVER['REQUEST_METHOD'] == "POST") {               
                $Admin_name = $_POST['Admin_name'];
                $admin_password = $_POST['admin_password'];
                $admin_email = $_POST['admin_email'];
                $admin_full_name = $_POST['admin_full_name'];

                $check_user = checkItem('username' , 'users' , $Admin_name);

                if($check_user == 1) {
                    $theMsg = "<div class = 'alert alert-danger'>Sorry this username is exit</div>";
                    redirect( $theMsg , "Back");
                } else {

                    $stmt = $con->prepare("INSERT INTO users(username , password , email , FullName , GroupID , RegsStatus, Date) 
                    VALUES(:Zuser , :Zpass , :Zemail , :Zfullname , 1 , 1, now())");

                    $stmt->execute(array(
                        "Zuser" => $Admin_name,
                        "Zpass" => $admin_password,
                        "Zemail" => $admin_email,
                        "Zfullname" => $admin_full_name
                    ));     
                }                
            ?>
                <!-- success message -->
                <?php
                    $mes = "Success of Inserting Admin";
                    redirect( $mes , 'success', 'members');
                ?>

            <?php       
            } else {
                header('Location:index.php');
            }
        }





        // this is for show the data of all admins in the website 
        elseif($do == 'PandingUsers') {
            $pading_userREGS = $_GET['RegsStatus'];                                                                   

                // ------------ $pading_userREGS has value (0) to select the user who pandaing and not activeted
                $stmt = $con->prepare('SELECT * FROM users WHERE GroupID = 0 AND RegsStatus =' . $pading_userREGS);
                $stmt->execute();
                $count_panding = $stmt->rowcount();

                if($count_panding > 0) {
                $rowPand = $stmt->fetchAll();

                echo "<h1 style='text-align:center; padding:50px 0;'>Panding users</h1>";

                echo "
                <div class='container'>
                <table class='table'>
                    <thead>
                        <tr>
                        <th scope='col'>#ID</th>
                        <th scope='col'>Username</th>
                        <th scope='col'>Email</th>
                        <th scope='col'>FullName</th>
                        <th scope='col'>Registerd Date</th>
                        <th scope='col'>Control</th>
                        </tr>
                    </thead>
                    <tbody>";

                        foreach($rowPand as $user_pand) {
                            echo "<tr>";
                                echo "<th>" .  $user_pand['userID'] . "</th>";
                                echo "<td>" .  $user_pand['username'] . "</td>";
                                echo "<td>" .  $user_pand['email'] . "</td>";
                                echo "<td>" .  $user_pand['FullName'] . "</td>";
                                echo "<td>" .  $user_pand['Date'] . "</td>";    // this for display the date of register of the user
                                echo "<td>
                                    <a href= 'members.php?do=Edit&userID=" . $user_pand['userID'] . "' class='btn btn-success'>Edit</a>
                                    <a href= 'members.php?do=Delete&userID=" . $user_pand['userID'] . "' class='btn btn-danger confirm'>Delete</a>
                                    <a href= 'members.php?do=Activate&userID=" . $user_pand['userID'] . "' class='btn btn-info confirm'>Active</a>";
                                echo "</td>";
                                            
                            echo "</tr>";
                            } 
                            ?>
                    </tbody>
                </table>
            </div>
            <?php
        } else {
            echo "<div class='container'>";
            $theMsg =  "<div class='alert alert-danger' style='margin: 50px 0; font-size:40px;'>No Data Found</div>";
            echo "</div>";
            redirect( $theMsg , 'dashboard');
        }           
    } 
        
        else {
            header('Location:index.php');
            }
        
        
    } else {
        header('Location:index.php');
    }

    

     

    