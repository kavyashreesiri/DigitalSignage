<?php

require('db_connect.php');
global $conn;
$a_id=$_POST['newdata'];
$a_id=json_decode($a_id,true);
//$e_id=$e_id[0];
    echo $e_id;
    global $conn;
    $sql = "DELETE FROM `announcements` WHERE a_id = '$a_id' ";
    if($conn->query($sql)===TRUE){
               echo "success";
    }
    else{
            echo "Error :" .$sql."<br>".$conn->error;
     }
