<?php
include("connec.php");
session_start();
$SchoolName=$_POST["SchoolName"];
$SchoolDepName=$_POST["SchoolDepName"];
$Order=$_POST["Order"];
$OrderID=$_POST["OrderID"];
$Type=$_POST["Type"];
$user=$_SESSION['user'];
$sql1;
$sql2;
$result1;
$result2;
$sql3;
$result3;
$html='';
if($Order=='up'){
    $OrderID--;
}else{
    if($Order=='down'){
        $OrderID++;
    }
}
$sql1=sprintf("UPDATE volfav SET `OrderID`=%d WHERE `UserID`='%s' AND `SchoolName`='%s' AND `SchoolDepName`='%s' AND `Type`='%s'",mysql_real_escape_string($OrderID),mysql_real_escape_string($user),mysql_real_escape_string($SchoolName),mysql_real_escape_string($SchoolDepName),mysql_real_escape_string($Type));
if($Order=='up'){
    $sql2=sprintf("UPDATE volfav SET `OrderID`=%d WHERE `UserID`='%s' AND (`SchoolName`<>'%s' or `SchoolDepName`<>'%s') AND `OrderID`=%d",mysql_real_escape_string(($OrderID+1)),mysql_real_escape_string($user),mysql_real_escape_string($SchoolName),mysql_real_escape_string($SchoolDepName),mysql_real_escape_string($OrderID));
}else{
    if($Order=='down'){
        $sql2=sprintf("UPDATE volfav SET `OrderID`=%d WHERE `UserID`='%s' AND (`SchoolName`<>'%s' or `SchoolDepName`<>'%s') AND `OrderID`=%d",mysql_real_escape_string(($OrderID-1)),mysql_real_escape_string($user),mysql_real_escape_string($SchoolName),mysql_real_escape_string($SchoolDepName),mysql_real_escape_string($OrderID));
    }
}
if($result1=$con->query($sql1)===TRUE){
    if($result2=$con->query($sql2)===TRUE){
        $sql3=sprintf("SELECT * FROM `volfav` JOIN `estimates` ON volfav.SchoolName=estimates.SchoolName AND volfav.SchoolDepName=estimates.DepType AND volfav.Type=estimates.Type where `UserID`='%s' ORDER BY `OrderID`",mysql_real_escape_string($user));
        $result3=$con->query($sql3);
        if($result3->num_rows>0){
            while($row1=$result3->fetch_assoc()){
                if($row1['SchoolName']==$SchoolName && $row1['SchoolDepName']==$SchoolDepName){
                    $html.='<tr class="select"><td style="text-align:center;"><input type="radio" name="order" checked="true"></td><td style="text-align:center;">'.$row1['OrderID'].'</td><td>'.$row1['SchoolName'].'</td><td>'.$row1['SchoolDepName'].'</td><td>'.$row1['ThisYearAdmission'].'</td><td style="text-align:center;"><button class="btn btn-danger" onclick="delvolfav(\''.$row1['Type'].'\',\''.$row1['SchoolName'].'\',\''.$row1['SchoolDepName'].'\','.$row1['OrderID'].')">刪除</button></td></tr>';
                }else{
                    $html.='<tr><td style="text-align:center;"><input type="radio" name="order"></td><td style="text-align:center;">'.$row1['OrderID'].'</td><td>'.$row1['SchoolName'].'</td><td>'.$row1['SchoolDepName'].'</td><td>'.$row1['ThisYearAdmission'].'</td><td style="text-align:center;"><button class="btn btn-danger" onclick="delvolfav(\''.$row1['Type'].'\',\''.$row1['SchoolName'].'\',\''.$row1['SchoolDepName'].'\','.$row1['OrderID'].')">刪除</button></td></tr>';
                }
            }
        }else{
            $html='<tr><td colspan="5" style="text-align:center;">查無資料</td></tr>';
        }
    }else{
        $html= "發生錯誤。";
    }
}else{
    $html= "發生錯誤。";
}
echo $html;
?>