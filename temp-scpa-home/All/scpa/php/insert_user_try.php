<?php
include("connec.php");
session_start();
$sql1="";
$sql2="";
$LastName=$_POST['LastName'];
$FirstName=$_POST['FirstName'];
$Phone=$_POST['Phone'];
$SchoolName=$_POST['SchoolName'];
$SchoolDepName=$_POST['SchoolDepName'];
$ChineseLevel=$_POST['ChineseLevel'];
$EnglishLevel=$_POST['EnglishLevel'];
$MathLevel=$_POST['MathLevel'];
$ProfessionOneLevel=$_POST['ProfessionOneLevel'];
$ProfessionTwoLevel=$_POST['ProfessionTwoLevel'];
$Chinese=$_POST['Chinese'];
$English=$_POST['English'];
$Math=$_POST['Math'];
$ProfessionOne=$_POST['ProfessionOne'];
$ProfessionTwo=$_POST['ProfessionTwo'];
$Type=$_POST['Type'];
$sql1=sprintf("SELECT * FROM `accounts_try`
WHERE `LastName`='%s' AND `FirstName`='%s' AND `Phone`='%s' AND `SchoolName` ='%s' AND `SchoolDepName`='%s'",mysql_real_escape_string($LastName),mysql_real_escape_string($FirstName),mysql_real_escape_string($Phone),mysql_real_escape_string($SchoolName),mysql_real_escape_string($SchoolDepName));
$result1=$con->query($sql1);
if($result1->num_rows==0){
    $sql2=sprintf("INSERT INTO `accounts_try`(`LastName`, `FirstName`, `Phone`, `SchoolName`, `SchoolDepName`, `Type`, `ChineseLevel`, `EnglishLevel`, `MathLevel`, `ProfessionOneLevel`, `ProfessionTwoLevel`, `Chinese`, `English`, `Math`, `ProfessionOne`, `ProfessionTwo`) VALUES ('%s','%s','%s','%s','%s','%s',%d,%d,%d,%d,%d,%d,%d,%d,%d,%d)",mysql_real_escape_string($LastName),mysql_real_escape_string($FirstName),mysql_real_escape_string($Phone),mysql_real_escape_string($SchoolName),mysql_real_escape_string($SchoolDepName),mysql_real_escape_string($Type),mysql_real_escape_string($ChineseLevel),mysql_real_escape_string($EnglishLevel),mysql_real_escape_string($MathLevel),mysql_real_escape_string($ProfessionOneLevel),mysql_real_escape_string($ProfessionTwoLevel),mysql_real_escape_string($Chinese),mysql_real_escape_string($English),mysql_real_escape_string($Math),mysql_real_escape_string($ProfessionOne),mysql_real_escape_string($ProfessionTwo));
    if($con->query($sql2) === TRUE){
        echo "OK";
    }else{
        echo "Error";
    }
}else{
    echo "NO";
}

$con->close();
?>