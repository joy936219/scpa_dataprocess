<?php
include('connec.php');
$data=$_POST["data"];
$html='';
$sql=sprintf("SELECT `LastYearLowScores`,`TwoYearLowScores`,`ThreeYearLowScores`,`TourYearLowScores` FROM `scorecollate` WHERE SchoolName='%s' AND SchoolDepName='%s' AND Type='%s'",mysql_real_escape_string($data["schoolname"]),mysql_real_escape_string($data["schooldepname"]),mysql_real_escape_string($data["Type"]));
$result=$con->query($sql);
if($result->num_rows>0){
    while($row=$result->fetch_assoc()){
        $html= '{"1":0,"2":'.$row["LastYearLowScores"].',"3":'.$row["TwoYearLowScores"].',"4":'.$row["ThreeYearLowScores"].',"5":'.$row["TourYearLowScores"].'}';
    }
    $html = str_replace("-106","0",$html);
    $html = str_replace("-105","0",$html);
    $html = str_replace("-104","0",$html);
    $html = str_replace("-103","0",$html);
    $html = str_replace("-3","0",$html);
    $html = str_replace("-4","0",$html);
    $html = str_replace("-5","0",$html);
    $html = str_replace("-6","0",$html);
    $html = str_replace("-1","0",$html);
    $html = str_replace("-2","0",$html);
}
echo $html;
$con->close();
?>