<?php

    $noNavbar = '';
    $pageTitle = "E-Commerce Shop";
    
    session_start();
    if(isset($_SESSION['name'])){ 
        header('location:dashboard.php'); 
        exit(); 
    }

    include 'init.php';                   // ======== include the init file ========   

    // =========== login form ===========

    if($_SERVER['REQUEST_METHOD'] == 'POST') {

        $username = $_POST['user'];
        $password = $_POST['pass'];

        // this for Encrypt password
        $hashedpass = sha1($password);

        // this for prepare the database in the table to be brings
        $stmt = $con->prepare(" SELECT 
                                    userID,username , password 
                                FROM 
                                    users 
                                WHERE 
                                    username = ? 
                                AND 
                                    password = ? 
                                AND 
                                    GroupID = 1
                                LIMIT 1" );        
        $stmt->execute(array($username , $password));
        // the fetch order is for get data from the database and work on it 
        $row = $stmt->fetch();
        
        // this for count the row which it found it in the database
        $count = $stmt->rowcount();

        if($count > 0) {
            $_SESSION['userID'] = $row['userID'];
            $_SESSION['username'] = $username;
            header('Location:dashboard.php');
            exit(); 
        }
    }
?>
 
<!-- ========== Start login form ========== -->
<form class="login" action="<?php $_SERVER['PHP_SELF']?>" method="POST">
    <h1>Admin Login</h1>
    <input type="text" name="user" placeholder="username" autocomplete="off">
    <input type="password" name="pass" placeholder="password" autocomplete="off">
    <input type="submit" value="submit">
</form>
<!-- ========== End login form ========== -->
    




