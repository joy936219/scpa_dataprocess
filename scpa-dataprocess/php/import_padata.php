<?php
mysql_query("SET NAMES 'UTF-8'");
set_time_limit(0); //無時間限制,必免執行逾時
ini_set('memory_limit', '256M');//提高內存容量限制

$target_path = "../uploadfiles/"; //指定上傳資料夾
$target_path.= $_FILES['file_name']['name'][0];
$new_filename = md5($_FILES['file_name']['name'][0]);
$ext = pathinfo($_FILES['file_name']['name'][0], PATHINFO_EXTENSION);//取得副檔名
$new_filename.= '.';
$new_filename.= $ext;

if (move_uploaded_file($_FILES['file_name']['tmp_name'][0], iconv("UTF-8", "big5", "../uploadfiles/" . $new_filename))){
    //echo "檔案：" . $_FILES['file_name']['name'][0] ;
}
else{
    echo "檔案上傳失敗，請再試一次!";
}
//引用套件
include ('../Classes/PHPExcel.php');
include ('../Classes/PHPExcel/Writer/Excel2007.php');
require_once ('../Classes/PHPExcel/IOFactory.php');

$reader = PHPExcel_IOFactory::createReader('Excel2007'); // 讀取2007 excel 檔案
$PHPExcel = $reader->load("../uploadfiles/" . $new_filename); // 檔案名稱 需已經上傳到主機上

for ($index=0; $index < 3 ; $index++) { 
    include ('conn.php');
    
    $query=null;
    $query_2= null;
    $sheet = $PHPExcel->getSheet($index); // 讀取第一個工作表(編號從 0 開始)
    $highestRow = $sheet->getHighestRow(); // 取得總列數
    $ColumnName = array();
    $data = array();
    $values = null;  
    $columnvalue = null;
    $delete_sql = null;
    switch ($index) {
        case 0:
            $delete_sql = "delete from quoscore";
            break;
        case 1:
            $delete_sql = "delete from thisyearbrief";
            break;
        case 2:
            $delete_sql = "delete from onlyone";
            break;
        
        default:
            # code...
            break;
    }
    //$delete_sql = "delete from scorecollate";

    $query = mysqli_query($conn, $delete_sql);
    $columncount = 0;
//判斷第幾個分頁
switch ($index) {
      case 0:
        $columncount = 15;
        break;
      case 1:
        $columncount = 77;
        break;
      case 2:
        $columncount = 6;
        break;
    
    default:
        # code...
        break;
}

$rowcheck=null;
// 一次讀取一列
for ($row = 2; $row <= $highestRow; $row++){
    for ($column = 0; $column <= $columncount; $column++){
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
                case '國立科大':
                    $ColumnName[$column]='1';
                    break;
                case '私立科大':
                    $ColumnName[$column]='2';
                    break;
                case '私立學院':
                    $ColumnName[$column]='3';
                    break;
                case '國立專校':
                    $ColumnName[$column]='4';
                    break;
                case '國立大學':
                    $ColumnName[$column]='5';
                    break;
                case '私立大學':
                    $ColumnName[$column]='6';
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
                if($index == 1){
                    
                        if($columnvalue == '必繳資料'){
                            $ColumnName[$column]=true;
                        }
                        else{
                            if($columnvalue == '選繳資料'){
                                $ColumnName[$column]=false;
                            }
                            
                        }
                    
                    
                }
                else{
                    if($index == 2){
                        if($column == 2 || $column == 3){
                            if($columnvalue == '是'){
                                 $ColumnName[$column]=true;
                            }
                            else{
                                $ColumnName[$column]=false;

                            }
                        }
                    
                    }
                }
                

                
            }
            
         //echo $ColumnName[$column].' ';

        }
    //利用迴圈產生insert into values 的值
        if($index == 2 && $ColumnName[0] == '-1'){
             continue;
        }
        $c=null;
    // echo "<br />";
        for ($i=0; $i <= $columncount ; $i++) { 
            $c .= "'$ColumnName[$i]',";
        }
        $c = substr($c,0,-1);
    //$values.= '("' . $ColumnName[1] . '","' . $ColumnName[2] . '","' . $ColumnName[3] . '","' . $ColumnName[4] . '","' . $ColumnName[5] . '","' . $ColumnName[6] . '","' . $ColumnName[7] . '","' . $ColumnName[8] . '","' . $ColumnName[9] . '"),';
        $c = "(" . $c . "),";
         $values .= $c;
    }
    $sql = '';
     //echo $c;
    switch ($index) {
        case 0:
            $sql = 'insert into quoscore  values ' . $values;
            break;
        case 1:
            $sql = 'insert into thisyearbrief  values ' . $values;
            break;
        case 2:
            $sql = 'insert into onlyone  values ' . $values;
            break;
        
        default:
            # code...
            break;
    }
    
    $sql = substr($sql, 0, -1);

// echo $sql;

$query_2 = mysqli_query($conn, $sql);
mysqli_close($conn);
}


//echo "匯入完成 將自動跳轉......";
$msg = $_FILES['file_name']['name'][0];
$msg .= ' 匯入完成';
echo "<script>alert('$msg');window.location.href='http://120.119.80.10/scpa-dataprocess/import.html'</script>";
?>