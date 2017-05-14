<?php
set_time_limit(0);//無時間限制
$target_path = "uploadfiles/"; //指定上傳資料夾
$target_path .= $_FILES['file_name']['name']; 

$new_filename = md5($_FILES['file_name']['name']);
$ext = pathinfo($_FILES['file_name']['name'],PATHINFO_EXTENSION);
$new_filename .='.';
$new_filename .=$ext;
if(move_uploaded_file($_FILES['file_name']['tmp_name'],
iconv("UTF-8", "big5", "uploadfiles/".$new_filename ))) {
echo "檔案：". $_FILES['file_name']['name'] . " 上傳成功!";
} else{
echo "檔案上傳失敗，請再試一次!";
}
include('Classes/PHPExcel.php');
include('Classes/PHPExcel/Writer/Excel2007.php');
include('conn.php');
require_once('Classes/PHPExcel/IOFactory.php');
$reader = PHPExcel_IOFactory::createReader('Excel2007'); // 讀取2007 excel 檔案
$PHPExcel = $reader->load("uploadfiles/". $new_filename); // 檔案名稱 需已經上傳到主機上
$sheet = $PHPExcel->getSheet(0); // 讀取第一個工作表(編號從 0 開始)
$highestRow = $sheet->getHighestRow(); // 取得總列數
$columnvalue = null;
$ColumnName = array();
$data = array();
$values = null;
$delete_sql = "delete from estimates";
$query = mysqli_query($conn,$delete_sql);
// 一次讀取一列
for ($row = 3; $row <= $highestRow; $row++) {
    for ($column = 0; $column <= 9; $column++) {
    	//if($column == 1){
    		$columnvalue = $sheet->getCellByColumnAndRow($column,$row)->getFormattedValue();
    	//}
    	//else{
    		//$columnvalue = $sheet->getCellByColumnAndRow($column, $row)->getValue();
    	//}
        

        //echo $ColumnName[$column].' ';
        if($column == 0){
        	switch ($columnvalue) {
        		case '動機群':
        			$ColumnName[$column] = '02 動力機械群';
        			break;
        		case '化工群':
        			$ColumnName[$column] = '05 化工群';
        			break;
        		case '商管群':
        			$ColumnName[$column] = '09 商業與管理群';
        			break;
        		case '土建群':
        			$ColumnName[$column] = '06 土木與建築群';
        			break;
        		case '工管類':
        			$ColumnName[$column] = '08 工程與管理類';
        			break;
        		case '幼保類':
        			$ColumnName[$column] = '12 家政群幼保類';
        			break;
        		case '影視類':
        			$ColumnName[$column] = '20 藝術群影視類';
        			break;
        		case '日語類':
        			$ColumnName[$column] = '16 外語群日語類';
        			break;
        		case '機械群':
        			$ColumnName[$column] = '01 機械群';
        			break;
        		case '水產群':
        			$ColumnName[$column] = '19 水產群';
        			break;
        		case '英語類':
        			$ColumnName[$column] = '15 外語群英語類';
        			break;
        		case '衛護類':
        			$ColumnName[$column] = '10 衛生與護理類';
        			break;
        		case '設計群':
        			$ColumnName[$column] = '07 設計群';
        			break;
        		case '資電類':
        			$ColumnName[$column] = '03 電機與電子群電機類';
        			break;
        		case '農業群':
        			$ColumnName[$column] = '14 農業群';
        			break;
        		case '電機類':
        			$ColumnName[$column] = '03 電機與電子群電機類';
        			break;
        		case '食品群':
        			$ColumnName[$column] = '11 食品群';
        			break;
        		case '餐旅群':
        			$ColumnName[$column] = '17 餐旅群';
        			break;        	
        		default:
        			$ColumnName[$column] = $columnvalue;
        			break;
        	}
   
        }
        else{
        	if(is_numeric($columnvalue)){
        		$ColumnName[$column] = $columnvalue;
        	}
       		else{
        		switch ($columnvalue) {
        			case '':
        				$ColumnName[$column] = '-1';
        				break;
        			case '分發無招生':
        				$ColumnName[$column]='-7';
        				break;
        			case '其他方式計分':
        				$ColumnName[$column]='-2';
        				break;
        			case '--':
        				$ColumnName[$column]='-6';
        				break;
        			case '無一般生名額':
        				$ColumnName[$column]='-5';
        				break;
        			case '甄選無招生':
        				$ColumnName[$column]='-3';
        				break;
        			case '未公告級分':
        				$ColumnName[$column]='-4';
        				break;
        			case '#N/A':
        				$ColumnName[$column]='-8';
        				break;
        		
        			default:
        				$ColumnName[$column] = $columnvalue;
        				break;
        		}
        	}
        }
        
    }
    
    $values .= '("'.$ColumnName[0].'","'.$ColumnName[1].'","'.$ColumnName[2].'","'.$ColumnName[3].'","'.$ColumnName[4].'","'.$ColumnName[5].'","'.$ColumnName[6].'","'.$ColumnName[7].'","'.$ColumnName[8].'","'.$ColumnName[9].'"),';
    	
}
$sql ='insert into estimates values '.$values;
$sql = substr($sql,0,-1);
    //echo $sql;
$query_2 = mysqli_query($conn,$sql);
mysqli_close($conn);
?>