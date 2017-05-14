<?php
mysql_query("SET NAMES 'UTF-8'");
set_time_limit(0); //無時間限制
$target_path = "../uploadfiles/"; //指定上傳資料夾
$target_path.= $_FILES['file_name']['name'][0];
$new_filename = md5($_FILES['file_name']['name'][0]);
$ext = pathinfo($_FILES['file_name']['name'][0], PATHINFO_EXTENSION);
$new_filename.= '.';
$new_filename.= $ext;

if (move_uploaded_file($_FILES['file_name']['tmp_name'][0], iconv("UTF-8", "big5", "../uploadfiles/" . $new_filename))){
    //echo "檔案：" . $_FILES['file_name']['name'][0] ;
}
else{
    echo "檔案上傳失敗，請再試一次!";
}

include ('../Classes/PHPExcel.php');

include ('../Classes/PHPExcel/Writer/Excel2007.php');

include ('conn.php');

require_once ('../Classes/PHPExcel/IOFactory.php');

$reader = PHPExcel_IOFactory::createReader('Excel2007'); // 讀取2007 excel 檔案
$PHPExcel = $reader->load("../uploadfiles/" . $new_filename); // 檔案名稱 需已經上傳到主機上
$sheet = $PHPExcel->getSheet(0); // 讀取第一個工作表(編號從 0 開始)
$highestRow = $sheet->getHighestRow(); // 取得總列數
$ColumnName = array();
$data = array();
$values = null;
$delete_sql = "delete from scorecollate";
$columnvalue = null;
$query = mysqli_query($conn, $delete_sql);

// 一次讀取一列

for ($row = 3; $row <= $highestRow; $row++){
    for ($column = 0; $column <= 25; $column++){
        $columnvalue = $sheet->getCellByColumnAndRow($column, $row)->getValue();
        if (is_numeric($columnvalue)){
            $ColumnName[$column] = $columnvalue;
            }
          else{
            switch ($columnvalue){
                case '':
                    $ColumnName[$column] = '-1';
                    break;

                case '分發無招生':
                     $ColumnName[$column] = '-7';
                     break;

                case '其他方式計分':
                    $ColumnName[$column] = '-2';
                    break;

                case '--':
                    $ColumnName[$column] = '-6';
                    break;

                case '無一般生名額':
                    $ColumnName[$column] = '-5';
                    break;

                case '甄選無招生':
                    $ColumnName[$column] = '-3';
                    break;

                case '未公告級分':
                    $ColumnName[$column]='-4';
                    break;

                case '#N/A':
                    $ColumnName[$column]='-8';
                    break;

                default:
                    if(strpos($columnvalue, '新增')>0){
                        $columnvalue = substr($columnvalue,0,-2);
                        $ColumnName[$column] = ('-' . $columnvalue);

                    }
                    else{
                        $ColumnName[$column] = $columnvalue;
                    }
                    
                    break;
                }
            }

        // echo $ColumnName[$column].' ';

        }
    //利用迴圈產生insert into values 的值
    $c=null;
    // echo "<br />";
    for ($i=0; $i <26 ; $i++) { 
        $c .= "'$ColumnName[$i]',";
    }
    $c = substr($c,0,-1);
    //$values.= '("' . $ColumnName[1] . '","' . $ColumnName[2] . '","' . $ColumnName[3] . '","' . $ColumnName[4] . '","' . $ColumnName[5] . '","' . $ColumnName[6] . '","' . $ColumnName[7] . '","' . $ColumnName[8] . '","' . $ColumnName[9] . '"),';
    $c = "(" . $c . "),";
    $values .= $c;
    }
     //echo $c;
$sql = 'insert into scorecollate  values ' . $values;
$sql = substr($sql, 0, -1);

// echo $sql;

$query_2 = mysqli_query($conn, $sql);
mysqli_close($conn);
//echo "匯入完成 將自動跳轉......";
$msg = $_FILES['file_name']['name'][0];
$msg .= ' 匯入完成';
echo "<script>alert('$msg');window.location.href='http://120.119.80.10/scpa-dataprocess/import.html'</script>";

?>



 

 
