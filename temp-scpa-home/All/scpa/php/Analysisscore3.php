<?php
include("connec.php");
$data=$_POST["Level"];
$Type=$_POST["Type"];
$NP=$_POST["NP"];
$Area=$_POST["Area"];
$table='';
//找保險區
$table.= '<tr class="th"><td></td><td></td><td>106</td><td></td><td>105</td><td></td><td>104</td><td></td><td></td></tr><tr class="th"><td>學校</td><td>系所</td><td>一般生<br>名額</td><td>日間分發<br>對應分數</td><td>一般生<br>名額</td><td>甄選入學<br>通過級分</td><td>一般生<br>名額</td><td>甄選入學<br>通過級分</td><td>詳細資訊</td></tr>';
if($NP=='0'){
    $sql3=sprintf('SELECT * FROM scorecollate JOIN onlyone ON scorecollate.SchoolName=onlyone.SchoolName where scorecollate.CatchScores >=%d-5 and scorecollate.CatchScores <=%d-3 and scorecollate.CatchScores >= 0 and scorecollate.Type=\'%s\' AND scorecollate.Area LIKE \'%%%s%%\' order by scorecollate.CatchScores desc',mysql_real_escape_string($data),mysql_real_escape_string($data),mysql_real_escape_string($Type),mysql_real_escape_string($Area));
}else{
    if($NP=='1'){
        $sql3=sprintf('SELECT * FROM scorecollate JOIN onlyone ON scorecollate.SchoolName=onlyone.SchoolName where scorecollate.CatchScores >=%d-5 and scorecollate.CatchScores <=%d-3 and scorecollate.CatchScores >= 0 and scorecollate.Type=\'%s\' AND scorecollate.Area LIKE \'%%%s%%\' AND onlyone.NP IN(\'1\',\'4\',\'5\') order by scorecollate.CatchScores desc',mysql_real_escape_string($data),mysql_real_escape_string($data),mysql_real_escape_string($Type),mysql_real_escape_string($Area));
    }else{
        if($NP=='2'){
            $sql3=sprintf('SELECT * FROM scorecollate JOIN onlyone ON scorecollate.SchoolName=onlyone.SchoolName where scorecollate.CatchScores >=%d-5 and scorecollate.CatchScores <=%d-3 and scorecollate.CatchScores >= 0 and scorecollate.Type=\'%s\' AND scorecollate.Area LIKE \'%%%s%%\' AND onlyone.NP IN(\'2\',\'3\',\'6\') order by scorecollate.CatchScores desc',mysql_real_escape_string($data),mysql_real_escape_string($data),mysql_real_escape_string($Type),mysql_real_escape_string($Area));
        }
    }
}
$result3=$con->query($sql3);
if($result3->num_rows>0){
    while($row = $result3->fetch_assoc()){
        $table.='<tr><td><a href="result2.html?SchoolName='.$row["SchoolName"].'&SchoolDepName='.$row["SchoolDepName"].'&Type='.$row["Type"].'" target="_blank">'.$row["SchoolName"].'</a></td><td>'.$row["SchoolDepName"].'</td><td>'.$row["ThisYearGeneralQuota"].'</td><td>'.$row["LastYearCollate"].'</td><td>'.$row["LastYearGeneralQuota"].'</td><td>'.$row["LastYearFractions"].'</td><td>'.$row["TwoYearGeneralQuota"].'</td><td>'.$row["TwoYearFractions"].'</td><td><button class="btn btn-default btn-block"  onclick="showdetail(\''.$row["Type"].'\',\''.$row["SchoolName"].'\',\''.$row["SchoolDepName"].'\')">分析</button></td></tr>';
    }
}else{
    $table.='<tr><td colspan=9 style="text-align:center;">查無資料</td></tr>';
}
$table = str_replace("-106","106新增",$table);
$table = str_replace("-105","105新增",$table);
$table = str_replace("-104","104新增",$table);
$table = str_replace("-103","103新增",$table);
$table = str_replace("-3","推甄不招生",$table);
$table = str_replace("-4","未公告級分",$table);
$table = str_replace("-5","無一般生名額",$table);
$table = str_replace("-6","--",$table);
$table = str_replace("-1"," ",$table);
$table = str_replace("-2","其他方式計分",$table);
echo $table;
$con->close();
?>