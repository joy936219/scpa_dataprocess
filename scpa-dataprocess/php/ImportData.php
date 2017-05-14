<?php
$name = $_FILES['file_name']['name'][0];
if($name=='' || $name ==null  ){
	                                  //回上一頁
	echo "<script>alert('請選擇檔案');history.go(-1);</script>";        
	return;
}
else{
	
}
if(isset($_POST['opt'])){
	switch ($_POST['opt']) {
	case '甄選入學落點分析資料':
		include('import_padata.php');
		break;
	case '使用者帳號資料':
		include('import_accounts.php');# code...
		break;
	case '甄選+日間錄取資料':
		include('import_distribution.php');
		break;
	case '分發預測錄取資料':
		include('import_estimates.php');
		break;
	case '甄選日間分數對照資料':
	    include('import_scorecollate.php');
	case '組距資料';
	    include('import_grpdis.php');

	default:
		# code...
		break;
	}
}



?>