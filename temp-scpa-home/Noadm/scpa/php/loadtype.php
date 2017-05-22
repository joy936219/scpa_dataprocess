<?php
include('connec.php');
$sql='select DISTINCT Type from quoscore';
echo '<option value="">請選擇類群</option>';
$result=$con->query($sql);
if($result->num_rows>0){
    while($row=$result->fetch_assoc()){
        if($row["Type"]!='21 資管類'){
            echo '<option value="'.$row["Type"].'">'.$row["Type"].'</option>';
        }
    }
}
$con->close();
?>