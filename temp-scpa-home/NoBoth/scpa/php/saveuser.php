<?php
include("connec.php");
$data=$_POST["data"];
$sql="";
$sql=sprintf("UPDATE `accounts` SET `SchoolName`='%s',`SchoolDepName`='%s',`FirstName`='%s',`LastName`='%s',Phone='%s',Type='%s',`Chinese`=%d,`ChineseLevel`=%d,`English`=%d,`EnglishLevel`=%d,`Math`=%d,`MathLevel`=%d,`ProfessionOne`=%d,`ProfessionOneLevel`=%d,`ProfessionTwo`=%d,`ProfessionTwoLevel`=%d WHERE `UserID`='%s'",mysql_real_escape_string($data["SchoolName"]),mysql_real_escape_string($data["SchoolDepName"]),mysql_real_escape_string($data["FirstName"]),mysql_real_escape_string($data["LastName"]),mysql_real_escape_string($data["Phone"]),mysql_real_escape_string($data["Type"]),mysql_real_escape_string($data["Chinese"]),mysql_real_escape_string($data["ChineseLevel"]),mysql_real_escape_string($data["English"]),mysql_real_escape_string($data["EnglishLevel"]),mysql_real_escape_string($data["Math"]),mysql_real_escape_string($data["MathLevel"]),mysql_real_escape_string($data["ProfessionOne"]),mysql_real_escape_string($data["ProfessionOneLevel"]),mysql_real_escape_string($data["ProfessionTwo"]),mysql_real_escape_string($data["ProfessionTwoLevel"]),mysql_real_escape_string($data["UserID"]));

if($con->query($sql) === TRUE){
    echo "OK";
}else{
    echo "Error";
}
$con->close();
?>