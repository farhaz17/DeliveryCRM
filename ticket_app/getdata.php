<?php 
$sql = "SELECT * FROM departments";
require_once('dbConnect.php');
//$con=mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_DATABASE);
$r = mysqli_query($con,$sql);
$result = array();
while($row = mysqli_fetch_array($r)){
 array_push($result,array(
'id'=>$row['id'],
'name'=>$row['name'],
    ));
}
echo json_encode(array('result'=>$result));
mysqli_close($con);?>