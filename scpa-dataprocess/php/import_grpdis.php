<?php
  //echo  $_FILES['file_name']['name'];
mysql_query("SET NAMES 'UTF-8'");
set_time_limit(0); //無時間限制,必免執行逾時
ini_set('memory_limit', '256M');//提高內存容量限制
$file_count = count($_FILES['file_name']['name']);//讀取共有幾個檔案
include ('../Classes/PHPExcel.php');

include ('../Classes/PHPExcel/Writer/Excel2007.php');



require_once ('../Classes/PHPExcel/IOFactory.php');
$msg = null;
for ($file_index= 0; $file_index < $file_count; $file_index ++) { 





$target_path = "../uploadfiles/"; //指定上傳資料夾
$target_path.= $_FILES['file_name']['name'][$file_index];
$new_filename = md5($_FILES['file_name']['name'][$file_index]);
$ext = pathinfo($_FILES['file_name']['name'][$file_index], PATHINFO_EXTENSION);
$new_filename.= '.';
$new_filename.= $ext;

if (move_uploaded_file($_FILES['file_name']['tmp_name'][$file_index], iconv("UTF-8", "big5", "../uploadfiles/" . $new_filename))){
    //echo "檔案：" . $_FILES['file_name']['name'][$file_index] ;
}
else{
    echo "檔案上傳失敗，請再試一次!";
}



$reader = PHPExcel_IOFactory::createReader('Excel2007'); // 讀取2007 excel 檔案
$PHPExcel = $reader->load("../uploadfiles/" . $new_filename); // 檔案名稱 需已經上傳到主機上
$sheet = $PHPExcel->getSheet(0); // 讀取第一個工作表(編號從 0 開始)
$highestRow = $sheet->getHighestRow(); // 取得總列數
$ColumnName = array();
$data = array();
$values = null;
$columnvalue = null;

$file_year = null;
$file_year_left_index = null;
$file_year_right_index = null;
$file_deltype = null;

$file_year_left_index = strpos($_FILES['file_name']['name'][$file_index],'(')+1;
$file_year_dash_index = strpos($_FILES['file_name']['name'][$file_index],'-')+1;
$file_year = substr($_FILES['file_name']['name'][$file_index], $file_year_left_index,3); //取得檔名中的年度
$file_deltype = substr(pathinfo($_FILES['file_name']['name'][$file_index],PATHINFO_FILENAME),$file_year_dash_index,strlen(pathinfo($_FILES['file_name']['name'][$file_index],PATHINFO_FILENAME))-$file_year_dash_index); //取得檔名中的類群

$ColumnName[0] = $file_year;
$ColumnName[1] = $file_deltype;
include ('conn.php');
$query = null ;
$query_2 = null;
$delete_sql = "delete from grpdis where year='$file_year' and Type ='$file_deltype'";
$query = mysqli_query($conn, $delete_sql);
// 一次讀取一列

for ($row = 2; $row <= $highestRow; $row++){
    for ($column = 0; $column <= 3; $column++){
        $columnvalue = $sheet->getCellByColumnAndRow($column, $row)->getValue();
        if (is_numeric($columnvalue)){
            $ColumnName[$column+2] = $columnvalue;
        }
        else{
            switch ($columnvalue) {
            	case '':
            		$ColumnName[$column+2] = '-1';
            		break;
            	
            	default:
            		$ColumnName[$column+2] = $columnvalue;
            		break;
            }
        }

        // echo $ColumnName[$column].' ';

        }
    //利用迴圈產生insert into values 的值
    $c=null;
    // echo "<br />";
    for ($i=0; $i < 6 ; $i++) { 
        $c .= "'$ColumnName[$i]',";
    }
    $c = substr($c,0,-1);
    //$values.= '("' . $ColumnName[1] . '","' . $ColumnName[2] . '","' . $ColumnName[3] . '","' . $ColumnName[4] . '","' . $ColumnName[5] . '","' . $ColumnName[6] . '","' . $ColumnName[7] . '","' . $ColumnName[8] . '","' . $ColumnName[9] . '"),';
    $c = "(" . $c . "),";
    $values .= $c;
    }
     //echo $c;
$sql = 'insert into grpdis  values ' . $values;
$sql = substr($sql, 0, -1);

 //echo $sql;

$query_2 = mysqli_query($conn, $sql);
mysqli_close($conn);
$msg .= $_FILES['file_name']['name'][$file_index];
$msg .='\n';



	
}
//echo "匯入完成 將自動跳轉......";
$msg .= '匯入完成';
echo "<script>alert('$msg');window.location.href='http://120.119.80.10/scpa-dataprocess/import.html'</script>"; 
?>