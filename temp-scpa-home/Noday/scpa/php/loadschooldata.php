<?php
include('connec.php');
$SchoolName=$_POST['SchoolName'];
$SchoolDepName=$_POST['SchoolDepName'];
$Type=$_POST['Type'];
$sql=sprintf("SELECT * FROM thisyearbrief JOIN onlyone on thisyearbrief.SchoolName=onlyone.SchoolName WHERE thisyearbrief.SchoolName='%s' and thisyearbrief.SchoolDepName='%s' and thisyearbrief.Type='%s'",mysql_real_escape_string($SchoolName),mysql_real_escape_string($SchoolDepName),mysql_real_escape_string($Type));
$result=$con->query($sql);
if($result->num_rows>0){
    $data=array();
    while($row=$result->fetch_assoc()){
        $data[]=$row;
    }
    echo json_encode($data);
}
?>