<?php
include("connec.php");
session_start();
if($_SESSION['user_try']=='' || $_SESSION['user_try']==null){
    echo "error";
}else{
    $user=$_SESSION['user_try'];
    $sql=sprintf("SELECT * FROM `Accounts` where UserID='%s' AND AccountLevel=%d",mysql_real_escape_string($user),1);
    $result = $con->query($sql);
    if($result->num_rows > 0){
        while($row = $result->fetch_assoc()){
            echo '{"UserID":"'.$row['UserID'].'","Password":"'.$row['Password'].'","SchoolName":"'.$row['SchoolName'].'","SchoolDepName":"'.$row['SchoolDepName'].'","FirstName":"'.$row['FirstName'].'","LastName":"'.$row['LastName'].'","Phone":"'.$row['Phone'].'","Type":"'.$row['Type'].'","Chinese":'.$row['Chinese'].',"ChineseLevel":'.$row['ChineseLevel'].',"English":'.$row['English'].',"EnglishLevel":'.$row['EnglishLevel'].',"Math":'.$row['Math'].',"MathLevel":'.$row['MathLevel'].',"ProfessionOne":'.$row['ProfessionOne'].',"ProfessionOneLevel":'.$row['ProfessionOneLevel'].',"ProfessionTwo":'.$row['ProfessionTwo'].',"ProfessionTwoLevel":'.$row['ProfessionTwoLevel'].',"AccountLevel":'.$row['AccountLevel'].'}';
        }
    }else{
        echo "error";
    }
    $con->close();
}
?>