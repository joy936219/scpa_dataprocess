<?php
include('connec.php');
$SchoolName=$_POST["SchoolName"];
$Type=$_POST["Type"];
$sql=sprintf("SELECT distinct `SchoolDepName` FROM `thisyearbrief` where SchoolName='%s' and Type='%s'",mysql_real_escape_string($SchoolName),mysql_real_escape_string($Type));
$result=$con->query($sql);
$html='';
if($result->num_rows>0){
    $html.='<option value="">請選擇科系</option>';
    $html.='<option value="">全部</option>';
    while($row = $result->fetch_assoc()){
        $html.='<option value="'.$row["SchoolDepName"].'">'.$row["SchoolDepName"].'</option>';
    }
}else{
    $html='<option value="">無招生名額</option>';
}
echo $html;
$con->close();
?>