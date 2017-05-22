<?php
include('connec.php');
session_start();

$school=$_POST["schoolname"];
$department=$_POST["schooldepname"];
$Type=$_POST["Type"];
$user=$_SESSION['user'];
$sql1=sprintf("SELECT * FROM `volfav` WHERE `UserID`='%s' ",mysql_real_escape_string($user));
$sql2=sprintf("SELECT * FROM `volfav` WHERE `UserID`='%s' and `SchoolName`='%s' and `SchoolDepName`='%s' and `Type`='%s'",mysql_real_escape_string($user),mysql_real_escape_string($school),mysql_real_escape_string($department),mysql_real_escape_string($Type));

$result1=$con->query($sql1);
if($result1->num_rows>=199){
    echo '<button type="button" class="btn btn-default btn-block" disabled>我的最愛已超過三個科系</button>';
}else{
    $result2=$con->query($sql2);
    if($result2->num_rows>=1)
    {
        echo '<button type="button" class="btn btn-default btn-block" disabled>已加入我的最愛</button>';
    }else{
        echo '<button type="button" class="btn btn-success btn-block" id="btnfav">加入我的最愛</button>';
    }
}
$con->close();
?>