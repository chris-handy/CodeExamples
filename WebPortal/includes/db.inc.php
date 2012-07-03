<?php
//db.inc.php
session_start();

$dbname = "hand0040";		//the name of the database that we want to talk with
$dbhost = "localhost";			// the webserver that we want to go through
$dbuser = "hand0040";			//the name of the database user account
$dbpass = "40577939";			//the password for our database user account

//$oConn
$oConn=mysql_connect($dbhost, $dbuser, $dbpass);

if($oConn){
	mysql_select_db($dbname, $oConn);
}else{
	exit("Could not connect to database.\n " . mysql_error());
}

?>