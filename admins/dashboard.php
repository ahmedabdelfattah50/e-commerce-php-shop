<?php

    $pageTitle = "Dashborad";
    session_start(); 
    if(isset($_SESSION['username'])) {
        include "init.php";
        
        echo "<div class='total_dashboard'>";
        echo "<div class='container'>";
        ?>

        <h1>dashboard</h1>
        <div class="total_members">
            <div class="members_count">
                <p>total admins</p>
                <a href="members.php?do=Admins&GroupID=1"><?php echo countItems("GroupID" , 'users' , 1)?></a>
            </div>

            <div class="members_count">
                <p>Total users</p>
                <a href="members.php"><?php echo countItems("GroupID" , 'users' , 0)?></a>                
            </div>

            <div class="members_count">
                <p>Panding users</p>    
                <a href="members.php?do=PandingUsers&RegsStatus=0"><?php echo checkItem("RegsStatus" , 'users' , 0)?></a>
            </div>

            <div class="members_count">
                <p>Total items</p>
                <a href="members.php">NULL</a>
            </div>

            <div class="members_count">
                <p>Total Comments</p>
                <a href="members.php">NULL</a>
            </div>

        </div>        
        
        <?php
                
                $user_limit = 10;
                $lates_users = getLatest('*' , 'users' , 'userID' , $user_limit);
                echo "<h1 style='text-align:left;'>Lates - $user_limit - Users</h1>";
                echo "<div class='lates_div'>";
                
                $i = 1;

                foreach($lates_users as $last_users){
                    echo $i . " - " . $last_users['username'] . "<br>";
                    echo "<a href='members.php?do=Edit&userID=" . $last_users['userID']  . "' class='btn btn-success'>Edit</a>";
                
                    if ($last_users['RegsStatus'] == 0){
                        echo "<a href= 'members.php?do=Activate&userID=" . $last_users['userID'] . "' class='btn btn-info confirm'>Active</a>";
                    }
                    $i++;
                }

            ?>
        </div>

        <?php
    }





