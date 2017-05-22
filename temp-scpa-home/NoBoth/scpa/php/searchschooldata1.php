<?php
include('connec.php');
$SchoolName=$_POST["SchoolName"];
$SchoolDepName=$_POST["SchoolDepName"];
$Type=$_POST["Type"];
$Area=$_POST["Area"];
$sql=sprintf("SELECT * FROM `thisyearbrief` JOIN onlyone ON thisyearbrief.SchoolName=onlyone.SchoolName where thisyearbrief.SchoolName like '%%%s%%' and thisyearbrief.SchoolDepName like '%%%s%%' and thisyearbrief.Type='%s' AND onlyone.Area LIKE '%%%s%%'",mysql_real_escape_string($SchoolName),mysql_real_escape_string($SchoolDepName),mysql_real_escape_string($Type),mysql_real_escape_string($Area));
$result=$con->query($sql);
$html='';
if($result->num_rows>0){
    while($row = $result->fetch_assoc()){
        $Area=explode(']',$row["Area"])[1];
        $html.='<tr><td>'.$Area.'</td><td>'.$row["Type"].'</td><td>'.$row["SchoolName"].'</td><td>'.$row["SchoolDepName"].'</td><td>'.$row["ChiWeighted"].'</td><td>'.$row["EngWeighted"].'</td><td>'.$row["MathWeighted"].'</td><td>'.$row["Pro1Weighted"].'</td><td>'.$row["Pro2Weighted"].'</td><td style="text-align:center;"><a class="btn btn-default" href="result2.html?SchoolName='.$row["SchoolName"].'&SchoolDepName='.$row["SchoolDepName"].'&Type='.$row["Type"].'" target="_blank">簡章</a></td></tr>';
    }
}else{
    $html='<tr><td>查無資料</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>';
}
echo $html;
$con->close();
?>