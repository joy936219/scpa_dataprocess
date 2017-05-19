<?php
 session_start();
 if(isset($_SESSION['userid'])){
   include('conn.php');
   $userid = $_SESSION['userid'];
   $sql = "Select LastName , FirstName from accounts where UserId ='$userid'";
   $result = mysqli_query($conn,$sql);
   $name = null;
   while ($row = mysqli_fetch_assoc($result)) {
   	    $name = $row['LastName'] . $row['FirstName'];
   } 
   echo $name;

 }
 else{
   echo "NO";
 }
?>