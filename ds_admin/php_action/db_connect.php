    
<?php  
$localhost = "localhost";
$username = "root";
$password =  "";
$dbname  = "ds_admin_db";
$conn = new mysqli($localhost,$username,$password,$dbname) or die("Connection failed" .mysqli_connect_error());
if($conn-> connect_error){
	die("Connection Failed:" .$conn->conn_error);
}else
{
	//echo "Successfully connected";
}
?>