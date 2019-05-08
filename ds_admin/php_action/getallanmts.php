<?php

require('db_connect.php');
$requestData= $_REQUEST;
$columns = array( 
  // datatable column index  => database column name
    0=>'a_id', 
    1=>'A_Title',
    2=>'A_Desc',
    3=>'A_Date',
    4=>'A_Time',
    5=>'A_Loc', 
    6=>'A_Flyer',
    7=>'A_More'

  );
  
// getting total number records without any search
  $sql = "SELECT `a_id`, `A_Title`, `A_Desc`, `A_Date`, `A_Time`, `A_Loc`, `A_Flyer`,`A_More` FROM `announcements`";
  $query=mysqli_query($conn, $sql) or die("getallannouncements.php: get announcements");
  $totalData = mysqli_num_rows($query);
  $totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.

  if( !empty($requestData['search']['value']) ) {
    // if there is a search parameter
    $sql = "SELECT `a_id`, `A_Title`, `A_Desc`, `A_Date`, `A_Time`, `A_Loc`,`A_Flyer`,`A_More` ";
    $sql.=" FROM `announcements`";
    $sql.=" WHERE A_Title LIKE '".$requestData['search']['value']."%' ";    
    // $requestData['search']['value'] contains search parameter
    $sql.=" OR E_More LIKE '".$requestData['search']['value']."%' ";
    $sql.=" OR E_Date LIKE '".$requestData['search']['value']."%' ";
    $query=mysqli_query($conn, $sql) or die("getallannouncements.php: get announcements");
    $totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result without limit in the query 
    $sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."   LIMIT ".$requestData['start']." ,".$requestData['length']."   "; 
    //$requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc , $requestData['start'] contains start row number ,$requestData['length'] contains limit length.
    $query=mysqli_query($conn, $sql) or die("getallannouncements.php: get announcements"); // again run query with limit
    
  } else {	
    $sql = "SELECT  `a_id`, `A_Title`, `A_Desc`, `A_Date`, `A_Time`, `A_Loc`,`A_Flyer`,`A_More` ";
    $sql.=" FROM `announcements`";
    $sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."   LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
    $query=mysqli_query($conn, $sql) or die("getallannouncements.php: get announcements");
    
  }
  $data = array();
  while( $row=mysqli_fetch_array($query) ) {  // preparing an array
    $nestedData=array(); 
    
    $nestedData[] = $row["a_id"];
    $nestedData[] = $row["A_Title"];
    $nestedData[] = $row["A_Desc"]; 
    $nestedData[] = $row["A_Date"];
    $nestedData[] = $row["A_Time"];
    $nestedData[] = $row["A_Loc"];
    $nestedData[] = $row["A_Flyer"];
    $nestedData[] = $row["A_More"];
   
    
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