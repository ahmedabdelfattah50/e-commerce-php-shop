<?php

    // $noNavbar = '';
    session_start();

    if(isset($_SESSION['name'])){ 
        header('location:dashboard.php'); exit(); 
    }

    include 'init.php';                   // ======== include the init file ========   

    // =========== login form ===========

    if($_SERVER['REQUEST_METHOD'] == 'POST') {

        $username = $_POST['user'];
        $password = $_POST['pass'];
        $hashedpass = sha1($password);

        // echo $password;

        // echo $hashedpass;
        //  648ba39c58d7f7360ae983e336aeccc13a2f56ef 

        $stmt = $con->prepare("SELECT username , password FROM users WHERE username = ? AND password = ? AND GroupID = 1");        
        $stmt->execute(array($username , $hashedpass));

        $count = $stmt->rowcount();

        if($count > 0 ) {
            echo "welcome " . $username . "I find if in database : " . $count;
        } else {
            echo "I can not Enter the database Ya " . $username;
        }

        // $_SESSION['username'] = $username;
        // header('Location:dashboard.php');
        // exit(); 
    }
?>
 
<!-- ========== Start login form ========== -->
<form class="login" action="<?php $_SERVER['PHP_SELF']?>" method="POST">
    <h1>User Login</h1>
    <input type="text" name="user" placeholder="username" autocomplete="off">
    <input type="password" name="pass" placeholder="password" autocomplete="off">
    <input type="submit" value="submit">
</form>
<!-- ========== End login form ========== -->
    


<?php include $tmpl . "footer.php"; ?>                      <!-- ======== include the footer ======== -->


