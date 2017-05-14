<?php
//echo "請稍後....";
include('../Classes/PHPExcel.php'); 
require_once('../Classes/PHPExcel.php'); 
require_once('../Classes/PHPExcel/IOFactory.php');
$objPHPExcel = new PHPExcel(); 
$objPHPExcel->setActiveSheetIndex(0);

include('conn.php');
$sql_column = "select column_comment 
from information_schema.columns 
where table_schema='scpa' and table_name = 'accounts' and column_comment <> '密碼' and column_comment <> '帳號等級。1:FB免費帳號。2:付費帳號。3.管理員'";
$result_column = mysqli_query($conn,$sql_column);
$sql_column_number_of_rows = mysqli_num_rows($result_column);
$column_index=0;
if($sql_column_number_of_rows > 0){
   while ($row_column = mysqli_fetch_assoc($result_column)) {
   		$objPHPExcel->getActiveSheet()->setCellValue(chr(65 + $column_index).(1),$row_column['column_comment']); 
   		$column_index++;
   }
}


$sql = 'SELECT `UserID`,`FirstName`,`LastName`,`Phone`,`SchoolName`,`SchoolDepName`,`Type`,`Chinese`,`ChineseLevel`,`English`,`EnglishLevel`,`Math`,`MathLevel`,`ProfessionOne`,`ProfessionOneLevel`,`ProfessionTwo`,`ProfessionTwoLevel`
from accounts';
$result = mysqli_query($conn,$sql);
$number_of_rows = mysqli_num_rows($result);
$data_array = array();
$column_index=2;
if($number_of_rows > 0){
   while ($row = mysqli_fetch_assoc($result)) {
   		$objPHPExcel->getActiveSheet()->setCellValue('A'.($column_index),$row['UserID']); 
   		$objPHPExcel->getActiveSheet()->setCellValue('B'.($column_index),$row['FirstName']); 
   		$objPHPExcel->getActiveSheet()->setCellValue('C'.($column_index),$row['LastName']); 
   		$objPHPExcel->getActiveSheet()->setCellValue('D'.($column_index),$row['Phone']); 
   		$objPHPExcel->getActiveSheet()->setCellValue('E'.($column_index),$row['SchoolName']); 
   		$objPHPExcel->getActiveSheet()->setCellValue('F'.($column_index),$row['SchoolDepName']); 
   		$objPHPExcel->getActiveSheet()->setCellValue('G'.($column_index),$row['Type']); 
   		$objPHPExcel->getActiveSheet()->setCellValue('H'.($column_index),$row['Chinese']); 
   		$objPHPExcel->getActiveSheet()->setCellValue('I'.($column_index),$row['ChineseLevel']); 
   		$objPHPExcel->getActiveSheet()->setCellValue('J'.($column_index),$row['English']); 
   		$objPHPExcel->getActiveSheet()->setCellValue('K'.($column_index),$row['EnglishLevel']); 
   		$objPHPExcel->getActiveSheet()->setCellValue('L'.($column_index),$row['Math']); 
   		$objPHPExcel->getActiveSheet()->setCellValue('M'.($column_index),$row['MathLevel']); 
   		$objPHPExcel->getActiveSheet()->setCellValue('N'.($column_index),$row['ProfessionOne']); 
   		$objPHPExcel->getActiveSheet()->setCellValue('O'.($column_index),$row['ProfessionOneLevel']); 
   		$objPHPExcel->getActiveSheet()->setCellValue('P'.($column_index),$row['ProfessionTwo']); 
   		$objPHPExcel->getActiveSheet()->setCellValue('Q'.($column_index),$row['ProfessionTwoLevel']); 
   		$column_index++;
   }
}

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007'); 
$objWriter->save('SCPA_StudentData.xlsx'); 
mysqli_close($conn);
echo "<script>window.location.href='http://120.119.80.10/scpa-dataprocess/php/SCPA_StudentData.xlsx';</script>";


?>
