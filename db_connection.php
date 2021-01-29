<?php
function OpenCon()
 {
 $dbhost = env('DB_HOST');
 $dbuser = env('DB_USERNAME');
 $dbpass = env('DB_PASSWORD');
 $db = env('DB_NAME');
 $conn = new mysqli($dbhost, $dbuser, $dbpass,$db) or die("Connect failed: %s\n". $conn -> error);
 
 return $conn;
 }
 
function CloseCon($conn)
 {
 $conn -> close();
 }
   
