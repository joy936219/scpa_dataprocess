<?php
include('connec.php');
$Area=$_POST["Area"];
$sql=sprintf('SELECT distinct thisyearbrief.SchoolName FROM thisyearbrief JOIN onlyone ON thisyearbrief.SchoolName=onlyone.SchoolName where onlyone.Area Like \'%%%s%%\'',mysql_real_escape_string($Area));
$result=$con->query($sql);
$html='';
$html.='<option value="">請選擇學校</option>';
$html.='<option value="">全部</option>';
if($result->num_rows>0){
    while($row = $result->fetch_assoc()){
        $html.='<option value="'.$row["SchoolName"].'">'.$row["SchoolName"].'</option>';
    }
}
echo $html;
$con->close();
?>