<?php
set_time_limit(0);//無時間限制
$target_path = "./uploadfiles/"; //指定上傳資料夾
$target_path .= $_FILES['file_name']['name']; 
if(move_uploaded_file($_FILES['file_name']['tmp_name'],
iconv("UTF-8", "big5", $target_path ))) {
echo "檔案：". $_FILES['file_name']['name'] . " 上傳成功!";
} else{
echo "檔案上傳失敗，請再試一次!";
}
include('./Classes/PHPExcel.php');
include('./Classes/PHPExcel/Writer/Excel2007.php');
include('conn.php');
require_once('./Classes/PHPExcel/IOFactory.php');
$reader = PHPExcel_IOFactory::createReader('Excel2007'); // 讀取2007 excel 檔案
$PHPExcel = $reader->load("./uploadfiles/". $_FILES['file_name']['name']); // 檔案名稱 需已經上傳到主機上
$sheet = $PHPExcel->getSheet(0); // 讀取第一個工作表(編號從 0 開始)
$highestRow = $sheet->getHighestRow(); // 取得總列數
$ColumnName = array();
$data = array();
$values = null;
$delete_sql = "delete from accounts";
$query = mysqli_query($conn,$delete_sql);
// 一次讀取一列
for ($row = 2; $row <= $highestRow; $row++) {
    for ($column = 0; $column <= 1; $column++) {
        $ColumnName[$column] = $sheet->getCellByColumnAndRow($column, $row)->getValue();
        //echo $ColumnName[$column].' ';
    }
 
    	$values .= '("'.$ColumnName[0].'","'.$ColumnName[1].'"),';
    	
}
$sql ='insert into accounts (UserId,PassWord) values '.$values;
$sql = substr($sql,0,-1);
    //echo $sql;
$query_2 = mysqli_query($conn,$sql);
mysqli_close($conn);
?>