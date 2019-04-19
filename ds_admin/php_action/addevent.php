<?php
header("Content-Type: application/json; charset=UTF-8");

require('db_connect.php');
$target_dir = "events/";
$allowedExts = array("gif", "jpeg", "jpg", "png");
$data=array();
//$data = stripcslashes($_POST['newdata']);
$data = $_POST['newdata'];
$data= json_decode($data,true);

$e_title=$data[0];
$e_date=strtotime($data[1]);

//
$e_date = date('Y-m-d', $e_date); 
$e_Starttime=$data[2];
$e_Endtime=$data[5];
$e_img=$data[4];
$e_url=$data[3];
$target_file = $target_dir . basename($_FILES["e_img"]["name"]);

  $sql = "INSERT INTO `events`(`E_Title`, `E_img`, `E_Date`, `E_Starttime`, `E_url`,`E_Endtime`) VALUES ('".$e_title."','".$e_img."','".$e_date."','".$e_Starttime."','".$e_Endtime."','".$e_url."')";
  $result = $conn->query($sql);
  if($conn->query($sql)===TRUE){
    echo "success";

  }else{
     echo "Error :" .$sql."<br>".$conn->error;
}


