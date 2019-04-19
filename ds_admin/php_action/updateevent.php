<?php

require('db_connect.php');
global $connect;
//if($_SERVER["REQUEST_METHOD"]=="POST"){ 
    $e_id=$_REQUEST['e_id'];
    $e_title=$_REQUEST['E_Title'];
    $e_date=$_REQUEST['E_Date'];
   // $e_date = date('Y-m-d', $e_date); 
    $e_img=$_REQUEST['E_img'];
    $e_Starttime=$_REQUEST['E_Starttime'];
    $e_Endtime=$_REQUEST['E_Endtime'];
    $e_more=$_REQUEST['E_More'];

    //$old_sql="SELECT `e_id`, `E_Title`, `E_img`, `E_Date`, `E_Starttime`, `E_More`, `E_Endtime` FROM `events` WHERE e_id='$e_id'";
    //$fetched_record=$connect->query($old_sql);
    //if($fetched_record->num_rows>0){
     //   while($row=$fetched_record->fetch_assoc()){
       //     if($row["e_id"] == $e_id)
         //   {
           //     if($row["E_Title"]!=$e_title){
             //       title_sql="UPDATE `events` SET `E_Title`=".$e_title." where e_id='$e_id'";"
               // }
                
            //}
            //echo " title ".$row["E_Title"]."";
       // }
   // }
    //else{
      //  echo "norecords";
    //}
    if(!empty($e_title)&&!empty( $e_date)&&!empty( $e_img)&&!empty( $e_Starttime)&&!empty( $e_Endtime)&&!empty( $e_more)){ 
        echo "in if";
        $sql = "UPDATE `events` SET `E_Title`='".$e_title."',`E_img`='".$e_img."',`E_Date`='".$e_date."',`E_Starttime`='".$e_Starttime."',`E_More`='".$e_more."',`E_Endtime`='".$e_Endtime."' WHERE e_id='$e_id'";
        if($connect->query($sql)===TRUE){
            echo "Updated successfully";
        }
        else{
             echo "Error :" .$sql."<br>".$connect->error;
        }
    }
    else{
        echo "Not updated";
    }

    
            
    //}
    
//}
//isset($_POST["password"]) && ($_POST["password"]=="$password")