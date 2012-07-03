<?php
require_once("includes/db.inc.php");

if( ! isset($_SESSION['user_name']) || ! isset($_SESSION['user_id'])){
	header("Location: logout.php");
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Textfile Login</title>
    <?php
	include_once("includes/style.inc.php");
	?>
</head>

<body>
<div id="wrapper">
	
    <div id="navbar">
    	<ul class="nav clearfix">
        	<li><a href="http://imd.edumedia.ca/hard0092/mtm4086/openID/openIDTest.php" title="login here">Home</a></li>
            <?php
			if( isset($_SESSION['user_id']) && isset($_SESSION['user_name']) ){
	            echo '<li><a href="secret.php" title="have to be logged in to see this">Private</a></li>';
			}
			?>
            <li><a href="logout.php" title="logout">Logout</a></li>
        </ul>
    </div>

	<div id="main">
    	<h2>The Secret Page</h2>
        <p>You must be logged in to see this page.</p>
    </div>
    
 </div>
</body>
</html>
