<?php
header("Content-Type: application/json; charset=UTF-8");

require('db_connect.php');
$data=array();

//$data = stripcslashes($_POST['newdata1']);
$data = $_POST['newdata1'];
$data= json_decode($data,true);

$a_title=$data[0];
$a_desc=$data[1];
$a_date=strtotime($data[2]);
$a_date = date('Y-m-d', $a_date); 
$a_time=$data[3];
$a_loc=$data[4];
$a_more=$data[5];

$sql1 = "INSERT INTO `announcements`(`A_Title`, `A_Desc`, `A_Date`, `A_Time`, `A_Loc`,`A_More`) VALUES ('".$a_title."','".$a_desc."','".$a_date."','".$a_time."','".$a_loc."','".$a_more."')";
$result = $conn->query($sql1);
if($conn->query($sql1)==TRUE)
{
    echo "success";
  
   
}
else{
     echo "Error :" .$sql1."<br>".$conn->error;
}
