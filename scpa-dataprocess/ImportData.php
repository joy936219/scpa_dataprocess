<?php
if(isset($_POST['opt'])){
	switch ($_POST['opt']) {
	case 'value':
		# code...
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
	case '甄選日蕳分數對照資料':
	    include('import_scorecollate.php');
	default:
		# code...
		break;
	}
}



?>