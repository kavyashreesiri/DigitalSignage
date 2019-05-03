<?php
header("Content-Type: application/json; charset=UTF-8");

require('php_action/db_connect.php');

$folder="events/";
$result=0;
$eid=0;
if ($_SERVER ['REQUEST_METHOD'] == "POST") {
  $sql_eid="SELECT e_id FROM `events` ORDER BY e_id DESC LIMIT 1";
  $result_eid = $conn->query($sql_eid);
  if($conn->query($sql_eid)==TRUE)
  {
    while($row = mysqli_fetch_array($result_eid)){
      echo $row['e_id'];
      $eid=$row['e_id']+1;
      echo $eid;
    }
  }
  else{
    echo "Error :" .$sql_eid."<br>".$conn->error;
  }
 if (isset ( $_FILES ['E_img'] )) {
        $errors = array ();
        $file_size = $_FILES ['E_img'] ['size'];
        $file_name = $_FILES ['E_img'] ['name'];
        $file_tmp = $_FILES ['E_img'] ['tmp_name'];
        $file_type = $_FILES ['E_img'] ['type'];
      
        $file_ext='jpeg';
        $fileName=$eid.".".$file_ext;
        $targetPath=$folder. $fileName;
        echo $targetPath;   
        $expensions = array (
                "jpeg",
                "jpg",
                "png" 
    );
    if (in_array ( $file_ext, $expensions ) === false) {
        $errors [] = "extension not allowed, please choose a JPEG or PNG file.";
    }
    

    if ($file_size > 10485760) {
        $errors [] = 'File size must be exactly 10 MB';
        echo  "<script>alert('File size must be exactly 10MB!!".$sql."');</script>";
    }      
    if (count ( $errors ) === 0) 
    {
            $status=move_uploaded_file ( $file_tmp, $targetPath );
            echo  "<script>alert(".$status.");</script>";
            echo "Status of file:".$status;
            $sql_update="UPDATE `events` SET `E_img`='$targetPath' WHERE e_id='$eid'";
            $result_update= $conn->query($sql_update);
            if($conn->query($sql_update)==TRUE){
                    $result=1;
                    echo $result;
                    echo "success";
                    header('Location:addevent.html');
            }
            else{
            echo "Error :" .$sql_update."<br>".$conn->error;
            echo  "<script>alert('Error uploading profile pic!!".$sql_update."');</script>";
            }
    }
}
else {
    print_r ( $errors );
}
}
?>