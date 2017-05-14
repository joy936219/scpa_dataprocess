<?php
session_start();
include('conn.php');

$uerid = $_POST['userid'];
$password = $_POST['password'];
//if(check($uerid)){
	//echo "<script>alert('登入失敗')</script>;history.go(-1);</script>";
	//return;
//}
//if(check($password)){
	//echo "<script>alert('登入失敗')</script>;history.go(-1);</script>";
	//return;
//}

$uerid =addslashes( $_POST['userid']);
$password =sha1($_POST['password']);

$sql = "select * from accounts where UserId ='$uerid' and PassWord ='$password' and AccountLevel ='3'"
$result = mysqli_query($conn,$sql);
$number_of_rows = mysqli_num_rows($result);
if($number_of_rows > 0){
	$row = mysqli_fetch_assoc($result);
	$_SESSION['userid'] = $row['UserID'];
	echo "<script>window.location.herf='import.html'</script>";
	
}
else{
	echo "<script>alert('帳號或密碼錯誤')</script>;history.go(-1);</script>";
	return;
}


function check($str){
   return eregi('select|insert|update|delete|\'|\/\*|\*|\.\.\/|\.\/|union|into|load_file|outfile', $str);
}

?>