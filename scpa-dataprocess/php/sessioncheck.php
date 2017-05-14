<?php
 session_start();
 if(isset($_SESSION['userid'])){
   echo "YES";
 }
 else{
   echo "NO";
 }
?>