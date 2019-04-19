<?php

require('db_connect.php');
$requestData= $_REQUEST;
$columns = array( 
  // datatable column index  => database column name
    0=>'e_id', 
    1=>'E_Title',
    2=>'E_img',
    3=>'E_Date',
    4=>'E_Starttime',
    5=> 'E_url', 
    6=>'E_Endtime'

  );
  
// getting total number records without any search
  $sql = "SELECT `e_id`, `E_Title`, `E_img`, `E_Date`, `E_Starttime`, `E_url`, `E_Endtime` FROM `events`";
  $query=mysqli_query($conn, $sql) or die("getallevents.php: get events");
  $totalData = mysqli_num_rows($query);
  $totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.

  if( !empty($requestData['search']['value']) ) {
    // if there is a search parameter
    $sql = "SELECT `e_id`, `E_Title`, `E_img`, `E_Date`, `E_Starttime`, `E_url`, `E_Endtime` ";
    $sql.=" FROM `events`";
    $sql.=" WHERE E_Title LIKE '".$requestData['search']['value']."%' ";    
    // $requestData['search']['value'] contains search parameter
    $sql.=" OR E_More LIKE '".$requestData['search']['value']."%' ";
    $sql.=" OR E_Date LIKE '".$requestData['search']['value']."%' ";
    $query=mysqli_query($conn, $sql) or die("getallevents.php: get events");
    $totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result without limit in the query 
    $sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."   LIMIT ".$requestData['start']." ,".$requestData['length']."   "; 
    //$requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc , $requestData['start'] contains start row number ,$requestData['length'] contains limit length.
    $query=mysqli_query($conn, $sql) or die("getallevents.php: get events"); // again run query with limit
    
  } else {	
    $sql = "SELECT  `e_id`, `E_Title`, `E_img`, `E_Date`, `E_Starttime`, `E_url`, `E_Endtime` ";
    $sql.=" FROM `events`";
    $sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."   LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
    $query=mysqli_query($conn, $sql) or die("getallevents.php: get events");
    
  }
  $data = array();
  while( $row=mysqli_fetch_array($query) ) {  // preparing an array
    $nestedData=array(); 
    $nestedData[] = $row["e_id"];
    $nestedData[] = $row["E_Title"];
    $nestedData[] = $row["E_Date"]; 
    $nestedData[] = $row["E_img"];
    $nestedData[] = $row["E_Starttime"];
    $nestedData[] = $row["E_Endtime"];
    $nestedData[] = $row["E_url"];
   
    
    $data[] = $nestedData;
  }

  $json_data = array(
    "draw"            => intval( $requestData['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
    "recordsTotal"    => intval( $totalData ),  // total number of records
    "recordsFiltered" => intval( $totalFiltered ), // total number of records after searching, if there is no searching then totalFiltered = totalData
    "data"            => $data   // total data array
    );
echo json_encode($json_data);  // send data as json format


 
?>