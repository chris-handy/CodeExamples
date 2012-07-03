<?php
//db.inc.php
session_start();

$dbname = "hard0092";		//the name of the database that we want to talk with
$dbhost = "localhost";			// the webserver that we want to go through
$dbuser = "hard0092";			//the name of the database user account
$dbpass = "40546396";			//the password for our database user account

//$oConn
$oConn=mysql_connect($dbhost, $dbuser, $dbpass);

if($oConn){
	mysql_select_db($dbname, $oConn);
}else{
	exit("Could not connect to database.\n " . mysql_error());
}

?>