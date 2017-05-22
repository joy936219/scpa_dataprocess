<?php
include('connec.php');
session_start();
$user=$_SESSION['user'];
$html='';
$sql1=sprintf("SELECT * FROM `volfav` JOIN `estimates` ON volfav.SchoolName=estimates.SchoolName AND volfav.SchoolDepName=estimates.DepType AND volfav.Type=estimates.Type where `UserID`='%s' ORDER BY `OrderID`",mysql_real_escape_string($user));
$result1=$con->query($sql1);
if($result1->num_rows>0){
    while($row1=$result1->fetch_assoc()){
        $SchoolName=$row1['SchoolName'];
        $SchoolDepName=$row1['SchoolDepName'];
        $Type=$row1['Type'];
        $html.='<tr><td style="text-align:center;"><input type="radio" name="order"></td><td style="text-align:center;">'.$row1['OrderID'].'</td><td>'.$SchoolName.'</td><td>'.$SchoolDepName.'</td><td>'.$row1['ThisYearQuota'].'</td><td>'.$row1['ThisYearAdmission'].'</td><td style="text-align:center;"><button class="btn btn-danger" onclick="delvolfav(\''.$Type.'\',\''.$SchoolName.'\',\''.$SchoolDepName.'\','.$row1['OrderID'].')">刪除</button></td></tr>';
    }
}else{
    $html='<tr><td colspan="5" style="text-align:center;">查無資料</td></tr>';
}
echo $html;
$con->close();
?>