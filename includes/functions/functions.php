<?php

    // this funtion is used to get the title of the current page
    function getTitle() {
        global $pageTitle;
        if(isset($pageTitle)) {
            echo $pageTitle;
        } else {
            echo "Shop";
        }
    }

    // this function is used to redirect errors when something is error 
    /**
     * ======= $theMsg is the var which used to display the message 
     * ======= $url is to give value when I want to back to previous page
     * ======= $seconds_refresh is the preiod time which used to wait and refresh the page after it
     */

    function redirect( $theMsg , $alert_type , $url = null, $seconds_refresh = 1) {

        echo "<div class='container'>";
        echo "<div class='alert alert-$alert_type' style='font-size:20px; margin-top:40px; font-weight:700;'>
        $theMsg </div>";
        echo "<div style='font-size: 20px;'>You will be returned to main page after $seconds_refresh Seconds</div>";
        echo "</div>";

        if( $url == null) {
            $url = "index.php";
        } else {
            if( isset($_SERVER['HTTP_REFERER']) && ( $_SERVER['HTTP_REFERER'] != '' )) {
                $url = $_SERVER['HTTP_REFERER'];
            } else {
                $url = $_SERVER['HTTP_REFERER'];
            }
        }

        header("refresh:$seconds_refresh;url=$url");
        exit();
    }

    // funtion checkItem ======>>>>>> is used to check the item is in database before add it or any option 
    /**
     * ======= $select is the item which I used it to check if it is in database or not 
     * ======= $from is the variable of which assign to the table in the datebase
     * ======= $value is the value which I used to search for it 
     */

    // this funtion is used to sort users without chosing admins
    function checkItem($select , $from , $value) {
        global $con;
        // ========= I put GroupID = 0 To select the users online which is not actavited without the admins
        $stmt2 = $con -> prepare("SELECT $select FROM $from WHERE $select = ? AND GroupID = 0 ");
        $stmt2 -> execute(array($value));
        $count = $stmt2 -> rowCount();
        
        return $count;
    }

    // this funtion is used to return the count of users in the database
    /**
     * ======= $item is the item which I will count the users by it
     * ======= $table is the table which I will use it search the item from it
     */

    // this funtion is used to calculate the number of users in the system
    /* -------- $admin_user is the varaible which used to 
                set the GroupID to differ between the users and admin to 
                calcualte its count    
    */

    function countItems($item , $table , $admin_user = 0) {
        global $con;
        $stmt3 = $con->prepare("SELECT COUNT($item) FROM $table WHERE GroupID = $admin_user"); 
        $stmt3->execute();
        return $stmt3->fetchColumn();
    }


    /**
     * Function getLatest is used to get the last items inserted in the databse 
     */

    function getLatest($select , $table , $order , $limit = 5){
        global $con;
        $getstmt = $con->prepare("SELECT $select FROM $table 
                                  ORDER BY $order DESC LIMIT $limit");
        $getstmt->execute();
        $rows = $getstmt->fetchAll();
        return $rows;
    }

    /**
     * function checkINdataBase
     * this function is used to check this item is in the database or not 
     */

    function checkINdataBase($select , $from , $value){
        global $con;
        $stmt3 = $con->prepare("SELECT $select FROM $from WHERE $select = ?");
        $stmt3 -> execute( array($value) );
        $count = $stmt3 -> rowCount();        
        return $count;        
    } 
    
