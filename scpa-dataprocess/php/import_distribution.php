<?php
mysql_query("SET NAMES 'UTF-8'");
set_time_limit(0);//無時間限制
$target_path = "../uploadfiles/"; //指定上傳資料夾

$target_path .= $_FILES['file_name']['name'][0]; 

$new_filename = md5($_FILES['file_name']['name'][0]);
$ext = pathinfo($_FILES['file_name']['name'][0],PATHINFO_EXTENSION);
$new_filename .='.';
$new_filename .=$ext;
if(move_uploaded_file($_FILES['file_name']['tmp_name'][0],
iconv("UTF-8", "big5","../uploadfiles/".$new_filename))) {
//echo "檔案：". $_FILES['file_name']['name'][0] . " 上傳成功!";
} else{
echo "檔案上傳失敗，請再試一次!";
}

include('../Classes/PHPExcel.php');
include('../Classes/PHPExcel/Writer/Excel2007.php');
include('conn.php');
require_once('../Classes/PHPExcel/IOFactory.php');
$reader = PHPExcel_IOFactory::createReader('Excel2007'); // 讀取2007 excel 檔案
$PHPExcel = $reader->load("../uploadfiles/".$new_filename); // 檔案名稱 需已經上傳到主機上
$sheet = $PHPExcel->getSheet(0); // 讀取第一個工作表(編號從 0 開始)
$highestRow = $sheet->getHighestRow(); // 取得總列數
$ColumnName = array();
$data = array();
$values = null;
$delete_sql = "delete from distribution";
$columnvalue=null;
$query = mysqli_query($conn,$delete_sql);
// 一次讀取一列
for ($row = 2; $row <= $highestRow; $row++) {
    for ($column = 1; $column <= 9; $column++) {
        $columnvalue = $sheet->getCellByColumnAndRow($column, $row)->getValue();
        if($column == 1){
        	  switch ($columnvalue) {
        	  	case '動機':
        	  		$ColumnName[$column] ='02 動力機械群';
        	  		break;
        	  	case '化工':
        	  		$ColumnName[$column] ='05 化工群';
        	  		break;
        	  	case '商管':
        	  		$ColumnName[$column] ='09 商業與管理群';
        	  		break;
        	  	case '土木':
        	  		$ColumnName[$column] ='06 土木與建築群';
        	  		break;
        	  	case '工管':
        	  		$ColumnName[$column] ='08 工程與管理類';
        	  		break;
        	  	case '幼保':
        	  		$ColumnName[$column] ='12 家政群幼保類';
        	  		break;
        	  	case '藝影':
        	  		$ColumnName[$column] ='20 藝術群影視類';
        	  		break;
        	  	case '日語':
        	  		$ColumnName[$column] ='16 外語群日語類';
        	  		break;
        	  	case '機械':
        	  		$ColumnName[$column] ='01 機械群';
        	  		break;
        	  	case '水產':
        	  		$ColumnName[$column] ='19 水產群';
        	  		break;
        	  	case '海事':
        	  		$ColumnName[$column] ='18 海事群';
        	  		break;
        	  	case '生活':
        	  		$ColumnName[$column] ='13 家政群生活應用類';
        	  		break;
        	  	case '英語':
        	  		$ColumnName[$column] ='15 外語群英語類';
        	  		break;
        	  	case '衛護':
        	  		$ColumnName[$column] ='10 衛生與護理類';
        	  		break;
        	  	case '設計':
        	  		$ColumnName[$column] ='07 設計群';
        	  		break;
        	  	case '資電':
        	  		$ColumnName[$column] ='04 電機與電子群資電類';
        	  		break;
        	  	case '農業':
        	  		$ColumnName[$column] ='14 農業群';
        	  		break;
        	  	case '電機':
        	  		$ColumnName[$column] ='03 電機與電子群電機類';
        	  		break;
        	  	case '食品':
        	  		$ColumnName[$column] ='11 食品群';
        	  		break;
        	  	case '餐旅':
        	  		$ColumnName[$column] ='17 餐旅群';
        	  		break;
        	  	case '資管':
        	  		$ColumnName[$column] ='21 資管類';
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
        		
        			default:
        				if(strpos($columnvalue, '新增')>0){
                             $columnvalue = substr($columnvalue,0,-2);
                             $ColumnName[$column] = ('-' . $columnvalue);

                        }
                        else{
                            $ColumnName[$column] = $columnvalue;
                        }
        		}
        	}
        }
       
        //echo $ColumnName[$column].' ';
    }
    // echo "<br>";
    	$values .= '("'.$ColumnName[1].'","'.$ColumnName[2].'","'.$ColumnName[3].'","'.$ColumnName[4].'","'.$ColumnName[5].'","'.$ColumnName[6].'","'.$ColumnName[7].'","'.$ColumnName[8].'","'.$ColumnName[9].'"),';
    	
}
$sql ='insert into distribution (`Type`, `SchoolName`, `DepType`, `ThisYearGeneralQuota`, `LastYearGeneralQuota`, `LastYearFractions`, `ThisYearDayQuota`, `LastYearDayQuota`, `LastYearDaySocores`) values '.$values;
$sql = substr($sql,0,-1);
    //echo $sql;
$query_2 = mysqli_query($conn,$sql);
mysqli_close($conn);
$msg = $_FILES['file_name']['name'][0];
$msg .= ' 匯入完成';
echo "<script>alert('$msg');window.location.href='http://120.119.80.10/scpa-dataprocess/import.html'</script>"; 

?>