<?php
session_start();
include('conn.php');



$uerid = $_POST['userid'];
$password = $_POST['password'];
if($uerid == ''){
	echo "<script>alert('請輸入帳號');history.go(-1);</script>";
	return;
}
if($password == ''){
	echo "<script>alert('請輸入密碼');history.go(-1);</script>";
	return;
}
if(check($uerid)){
	echo "<script>alert('登入失敗');history.go(-1);</script>";
	return;
}
if(check($password)){
	echo "<script>alert('登入失敗');history.go(-1);</script>";
	return;
}

$uerid =addslashes( $_POST['userid']);
$password =sha1($_POST['password']);

$sql = "select * from accounts where UserId ='$uerid' and PassWord ='$password' and AccountLevel ='3'";
$result = mysqli_query($conn,$sql);
$number_of_rows = mysqli_num_rows($result);
if($number_of_rows > 0){
	$row = mysqli_fetch_assoc($result);
	$_SESSION['userid'] = $row['UserID'];
	echo "<script>window.location.href='http://120.119.80.10/scpa-dataprocess/import.html'</script>";
	
}
else{
	echo "<script>alert('帳號或密碼錯誤');history.go(-1);</script>";
	return;
}


function check($str){
   return eregi('select|insert|update|delete|\'|\/\*|\*|\.\.\/|\.\/|union|into|load_file|outfile', $str);
}

?>