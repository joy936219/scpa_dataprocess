<?php
include('connec.php');
$Type=$_POST["Type"];
$Year=$_POST["Year"];
$sql=sprintf("SELECT * FROM grpdis WHERE Type = '%s' AND Year=%d",mysql_real_escape_string($Type),mysql_real_escape_string($Year));
$result=$con->query($sql);
$html='';
if($result->num_rows>0){
    while($row = $result->fetch_assoc()){
        $html.='<tr><td>'.$row["LowScores"].'</td><td>'.$row["HighScores"].'</td><td>'.$row["Count"].'</td><td>'.$row["Accumulation"].'</td></tr>';
    }
}else{
    $html='<tr><td>查無資料</td><td></td><td></td><td></td></tr>';
}
$html = str_replace("-106","106新增",$html);
$html = str_replace("-105","105新增",$html);
$html = str_replace("-104","104新增",$html);
$html = str_replace("-103","103新增",$html);
$html = str_replace("-3","推甄不招生",$html);
$html = str_replace("-4","未公告級分",$html);
$html = str_replace("-5","無一般生名額",$html);
$html = str_replace("-6","--",$html);
$html = str_replace("-1"," ",$html);
$html = str_replace("-2","其他方式計分",$html);
echo $html;
$con->close();
?>