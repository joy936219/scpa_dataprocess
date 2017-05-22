<?php
include("connec.php");
$Total1=$_POST["Total1"];
$Type=$_POST["Type"];
$NP=$_POST["NP"];
$Area=$_POST["Area"];
$table='';
//找挑戰區
$table.= '<tr class="th"><td></td><td></td><td>105</td><td></td><td>106</td><td></td><td></td></tr><tr class="th"><td>學校名稱</td><td>系科組<br>名稱</td><td>分發名額</td><td>錄取分數</td><td>分發名額</td><td>預估分數</td><td>詳細資訊</td></tr>';
$sql1='';
if($NP=='0'){
    $sql1=sprintf('SELECT * FROM estimates JOIN onlyone ON estimates.SchoolName=onlyone.SchoolName WHERE estimates.ThisYearAdmission>=%d+20 AND estimates.ThisYearAdmission<=%d+40 AND estimates.Type=\'%s\' AND estimates.Area LIKE \'%%%s%%\' ORDER BY estimates.Sort ASC',mysql_real_escape_string($Total1),mysql_real_escape_string($Total1),mysql_real_escape_string($Type),mysql_real_escape_string($Area));
}else{
    if($NP=='1'){
        $sql1=sprintf('SELECT * FROM estimates JOIN onlyone ON estimates.SchoolName=onlyone.SchoolName WHERE estimates.ThisYearAdmission>=%d+20 AND estimates.ThisYearAdmission<=%d+40 AND estimates.Type=\'%s\' AND estimates.Area LIKE \'%%%s%%\' AND onlyone.NP IN(\'1\',\'4\',\'5\') ORDER BY estimates.Sort ASC',mysql_real_escape_string($Total1),mysql_real_escape_string($Total1),mysql_real_escape_string($Type),mysql_real_escape_string($Area));
    }else{
        if($NP=='2'){
            $sql1=sprintf('SELECT * FROM estimates JOIN onlyone ON estimates.SchoolName=onlyone.SchoolName WHERE estimates.ThisYearAdmission>=%d+20 AND estimates.ThisYearAdmission<=%d+40 AND estimates.Type=\'%s\' AND estimates.Area LIKE \'%%%s%%\' AND onlyone.NP IN(\'2\',\'3\',\'6\') ORDER BY estimates.Sort ASC',mysql_real_escape_string($Total1),mysql_real_escape_string($Total1),mysql_real_escape_string($Type),mysql_real_escape_string($Area));
        }
    }
}
$result1=$con->query($sql1);
if($result1->num_rows>0){
    while($row = $result1->fetch_assoc()){
        $table.='<tr><td><a href="'.$row["URL"].'" target="_blank">'.$row["SchoolName"].'</a></td><td>'.$row["DepType"].'</td><td>'.$row["LastYearQuota"].'</td><td>'.$row["LastYearAdmission"].'</td><td>'.$row["ThisYearQuota"].'</td><td>'.$row["ThisYearAdmission"].'</td><td><button class="btn btn-default btn-block"  onclick="showdetail(\''.$row["Type"].'\',\''.$row["SchoolName"].'\',\''.$row["DepType"].'\')">分析</button></td></tr>';
    }
}else{
    $table.='<tr><td colspan=7 style="text-align:center;">查無資料</td></tr>';
}
$table = str_replace("-106","106新增",$table);
$table = str_replace("-105","105新增",$table);
$table = str_replace("-104","104新增",$table);
$table = str_replace("-103","103新增",$table);
$table = str_replace("-3","日間分發不招生",$table);
$table = str_replace("-4","未公告級分",$table);
$table = str_replace("-5","無一般生名額",$table);
$table = str_replace("-6","--",$table);
$table = str_replace("-1"," ",$table);
$table = str_replace("-2","其他方式計分",$table);
echo $table;
$con->close();
?>