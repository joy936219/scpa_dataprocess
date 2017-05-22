<?php
include('connec.php');
$Type="";
$Type=$_POST["Type"];
$sql=sprintf("select DISTINCT Type from quoscore where Type='%s'",mysql_real_escape_string($Type));
$result=$con->query($sql);
if($result->num_rows>0){
    while($row=$result->fetch_assoc()){
        if($row["Type"]!='09 商業與管理群'){
            echo '<option value="'.$row["Type"].'">'.$row["Type"].'</option>';
        }else{
            echo '<option value="'.$row["Type"].'">'.$row["Type"].'</option>';
        }
    }
}
$con->close();
?>