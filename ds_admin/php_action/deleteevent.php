<?php

require('db_connect.php');
global $conn;
$e_id=$_POST['newdata'];
$e_id=json_decode($e_id,true);
//$e_id=$e_id[0];
    echo $e_id;
    global $conn;
    $sql = "DELETE FROM `events` WHERE e_id = '$e_id' ";
    if($conn->query($sql)===TRUE){
               echo "success";
    }
    else{
            echo "Error :" .$sql."<br>".$conn->error;
     }
