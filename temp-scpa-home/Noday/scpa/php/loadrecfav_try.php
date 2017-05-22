<?php
include('connec.php');
session_start();
$user=$_SESSION['user_try'];
$html='';
$sql1=sprintf("SELECT * FROM `recfav` where `UserID`='%s'",mysql_real_escape_string($user));
$result1=$con->query($sql1);
$rows=0;
if($result1->num_rows>0){
    while($row1=$result1->fetch_assoc()){
        $rows=$rows+1;
        $SchoolName=$row1['SchoolName'];
        $SchoolDepName=$row1['SchoolDepName'];
        $Type=$row1['Type'];
        $sql2=sprintf("SELECT recfav.UserID,recfav.SchoolName,recfav.Type, recfav.SchoolDepName, accounts.ChineseLevel+accounts.EnglishLevel+accounts.MathLevel+accounts.ProfessionOneLevel+accounts.ProfessionTwoLevel as 'scroce' FROM recfav, accounts WHERE recfav.UserID=accounts.UserID and recfav.SchoolName='%s' and recfav.SchoolDepName='%s' and recfav.Type='%s' ORDER BY scroce DESC",mysql_real_escape_string($SchoolName),mysql_real_escape_string($SchoolDepName),mysql_real_escape_string($Type));
        $result2=$con->query($sql2);
        if($result2->num_rows>0){
            $no=0;
            while($row2=$result2->fetch_assoc()){
                $no=$no+1;
                if($row2['UserID']==$user){
                    $html.='<tr><td>'.$rows.'.</td><td>'.$SchoolName.'</td><td>'.$SchoolDepName.'</td><td>'.$no.'</td><td style="text-align:center;"><button class="btn btn-danger" onclick="delrecfav(\''.$Type.'\',\''.$SchoolName.'\',\''.$SchoolDepName.'\')">刪除</button></td><td style="text-align:center;"><a class="btn btn-default" href="result2.html?SchoolName='.$SchoolName.'&SchoolDepName='.$SchoolDepName.'&Type='.$Type.'" target="_blank">簡章</a></td></tr>';
                }
            }
        }
    }
}else
{
    $html='<tr><td colspan="6" style="text-align:center;">查無資料</td></tr>';
}
echo $html;
$con->close();
?>