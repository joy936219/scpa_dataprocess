<?php
include('conn.php');

$sql = "select name,status from control";

$result = mysqli_query($conn,$sql);
$row_num = mysqli_num_rows($result);
$data = array();
if($row_num > 0){
	while ($row = mysqli_fetch_assoc($result)) {
		$data[] = $row;
		# code...
	}
}
header('Content-Type: application/json');
echo json_encode($data);
mysqli_close($conn);


?>