<?php
include("connec.php");
$sql='SELECT DISTINCT SUBSTRING(`Area`,5) as "area" FROM `onlyone`';
$result=$con->query($sql);
$html='<option value="">請選擇地區</option>';
$html.='<option value="">全部</option>';
if($result->num_rows>0){
    while($row=$result->fetch_assoc()){
        if($row['area']!=""){
            $html.='<option value="'.$row['area'].'">'.$row['area'].'</option>';
        }
    }
}
echo $html;
?>