<?php
header("Content-Type: application/json; charset=UTF-8");

require('php_action/db_connect.php');

$folder="announcements/";
$result=0;
$aid=0;
if ($_SERVER ['REQUEST_METHOD'] == "POST") {
  $sql_aid="SELECT a_id FROM `announcements` ORDER BY a_id DESC LIMIT 1";
  $result_aid = $conn->query($sql_aid);
  if($conn->query($sql_aid)==TRUE)
  {
    while($row = mysqli_fetch_array($result_aid)){
      echo $row['a_id'];
      $aid=$row['a_id'];
      echo $aid;
    }
  }
  else{
    echo "Error :" .$sql_eid."<br>".$conn->error;
  }
 if (isset ( $_FILES ['A_Flyer'] )) {
        $errors = array ();
        $file_size = $_FILES ['A_Flyer'] ['size'];
        $file_name = $_FILES ['A_Flyer'] ['name'];
        $file_tmp = $_FILES ['A_Flyer'] ['tmp_name'];
        $file_type = $_FILES ['A_Flyer'] ['type'];
        $file_ext = strtolower ( end ( explode ( '.', $_FILES ['A_Flyer'] ['name'] ) ) );
        //$file_ext='jpeg';
        $fileName=$aid.".".$file_ext;
        $targetPath=$folder. $fileName;
        echo $targetPath;   
        $expensions = array (
                "jpeg",
                "jpg",
                "png",
                "pdf",
                "doc"
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
            $sql_update="UPDATE `announcements` SET `A_Flyer`='./announcements/".$fileName."' WHERE a_id='$aid'";
            $result_update= $conn->query($sql_update);
            if($conn->query($sql_update)==TRUE){
                    $result=1;
                    echo $result;
                    echo "success";
                    //header('Location:addevent.html');
            }
            else{
            echo "Error :" .$sql_update."<br>".$conn->error;
            echo  "<script>alert('Error uploading!!".$sql_update."');</script>";
            }
    }
}
else {
    print_r ( $errors );
}
}
?>