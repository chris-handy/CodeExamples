<?php
require_once("includes/db.inc.php");
require('includes/class.openid.v3.php');




if(($_POST['url'] && $_POST['user']) || ($_POST['user'] && $_POST['ruser']) || ($_POST['url'] && $_POST['ruser']) || ($_POST['url'] && $_POST['ruser']&& $_POST['user'])){
	
	$errMsg = "Sorry, please use one method to sign in."; //-- letting the user know I'm smarter 
	
}else{
	//-----------------------------------------SignIn---------------
	if($_POST['user']){
		$u = mysql_real_escape_string(trim($_POST['user']));
		$p = md5(trim($_POST['pass']));
		
		$strSQL = "SELECT * FROM users WHERE user_name='".$u."' AND pwd='".$p."'";
		$RS= mysql_query($strSQL);
		switch(mysql_num_rows($RS)){
			case 0:
				//--no match
				$errMsg="Sorry no match found.";
				break;
			case 1:
				//--match found
				$_SESSION['user_name'] = $u;
				$_SESSION['user_id'] =  uniqid('UU_', true);
				break;
			default;
				//--hack attempt
				$errMsg="Go Hack Off!.";
		}
	
	}
	//----------------------------OpenID---------------------
	else if($_POST['url']){
		
		$openid = new SimpleOpenID;
		$openid->SetIdentity($_POST['url']);
		$openid->SetTrustRoot('http://' . $_SERVER["HTTP_HOST"] . '/hard0092/mtm4086/openID/openIDTest.php');
		$openid->SetRequiredFields(array('email','fullname'));
		$openid->SetOptionalFields(array('dob','gender','postcode','country','language','timezone'));
		if ($openid->GetOpenIDServer()){
			$openid->SetApprovedURL('http://'.$_SERVER["HTTP_HOST"].'/hard0092/mtm4086/openID/openIDTest.php'.$_SERVER["PATH_INFO"]);//--Send Response from OpenID server to this script
			$openid->Redirect(); 	//--This will redirect user to OpenID Server
		}else{
			$error = $openid->GetError();
			echo "ERROR CODE: " . $error['code'] . "<br>";
			echo "ERROR DESCRIPTION: " . $error['description'] . "<br>";
		}
		exit;
	}
	else if($_GET['openid_mode'] == 'id_res'){ 	//-- Perform HTTP Request to OpenID server to validate key
		$openid = new SimpleOpenID;
		$openid->SetIdentity($_GET['openid_identity']);
		$openid_validation_result = $openid->ValidateWithServer();
		if ($openid_validation_result == true){ 		//-- OK HERE KEY IS VALID    	
//////////////////////////////////////////////////////////////GRAB INFO AND ENTER IT INTO THE DB THEN SET UU_ID FOR AUTH.////////////////////////////////////////////////////////
			$strSQL = "SELECT * FROM users WHERE email='".$_GET['openid_sreg_email']."'";
			$RS= mysql_query($strSQL);
			$numOfRows=mysql_num_rows($RS);
			if(!$numOfRows){
				//--no match
				$u = mysql_real_escape_string(trim($openid->GetIdentity()));
				$f = mysql_real_escape_string(trim($_GET['openid_sreg_fullname']));
				$e = mysql_real_escape_string(trim($_GET['openid_sreg_email']));
				$p = md5(trim($openid->GetIdentity));	
				$strSQL1 = "INSERT INTO users(user_name, pwd, f_name, email) VALUES('".$u."', '".$p."', '".$f."', '".$e."' )";
				$RS1 = mysql_query($strSQL1);				
				$_SESSION['user_name'] = $u;
				$_SESSION['user_id'] =  uniqid('UU_', true);				
			}else{
				$u = mysql_real_escape_string(trim($openid->GetIdentity()));
				$_SESSION['user_name'] = $u;
				$_SESSION['user_id'] =  uniqid('UU_', true);				
			}
		}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////	
		else if($openid->IsError() == true){			//-- ON THE WAY, WE GOT SOME ERROR
			$error = $openid->GetError();
			echo "ERROR CODE: " . $error['code'] . "<br>";
			echo "ERROR DESCRIPTION: " . $error['description'] . "<br>";
		}else{											//-- Signature Verification Failed
			echo "INVALID AUTHORIZATION";
		}
	}else if ($_GET['openid_mode'] == 'cancel'){ //-- User Canceled your Request
		echo "USER CANCELED REQUEST";
	}
	//--------------------------------------------------------
	//----------------------NEW USER----------------------------
	else if($_POST['ruser'] && $_POST['rfname'] && $_POST['remail']  && ($_POST['rpass'] == $_POST['rrpass'])){
		$strSQL = "SELECT * FROM users WHERE user_name='".$_POST['ruser']."'";
		$RS= mysql_query($strSQL);
		$numOfRows=mysql_num_rows($RS);
			if(!$numOfRows){
				$numOfRows=0;
				$strSQL = "SELECT * FROM users WHERE  email='".$_POST['remail']."'";
				$RS= mysql_query($strSQL);
				$numOfRows=mysql_num_rows($RS);
					if(!$numOfRows){
						//--no match
						$u = mysql_real_escape_string(trim($_POST['ruser']));
						$f = mysql_real_escape_string(trim($_POST['rfname']));
						$e = mysql_real_escape_string(trim($_POST['remail']));
						$p = md5(trim($_POST['rrpass']));	
						$strSQL = "INSERT INTO users(user_name, pwd, f_name, email) VALUES('".$u."', '".$p."', '".$f."', '".$e."' )";
						$RS= mysql_query($strSQL);
						$_SESSION['user_name'] = $u;
						$_SESSION['user_id'] =  uniqid('UU_', true);				
					}else{
					//--match found
						$errMsg = "Sorry, that Email has already been entered. Please enter a different email.";
					}
			}else{
				//--match found
					$errMsg = "Sorry, that User Name is being used.";
			}
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>OpenID Login</title>
    <?php
	include_once("includes/style.inc.php");
	?>
</head>
<body>
<div id="wrapper">
	
    <div id="navbar">
    	<ul class="nav clearfix">
        	<li><a href="openIDTest.php" title="login here">Home</a></li>
            <?php
			if( $_SESSION['user_id'] && $_SESSION['user_name'] ){
	            echo '<li><a href="#" title="have to be logged in to see this">Gogle Maps (coming soon)</a></li>';
				echo '<li><a href="#" title="have to be logged in to see this">Portal Page (coming soon)</a></li>';
				echo '<li><a href="logout.php" title="logout">Logout</a></li>';
			}
			?>
        </ul>
    </div>

	<div id="main">
	<?php
		if($errMsg){//--check for errors
			echo '<p class="error">';
			echo $errMsg;
			echo '</p>';
		}
		//--only  show the login form IF the user is NOT logged in
		if( isset($_SESSION['user_id']) && isset($_SESSION['user_name']) ){
			echo "<p>You are currently logged in to the site. Welcome ".$u.". </p>";
		
		}else{
	?>
	<form name="loginForm" id="loginForm" method="post" action="<?=$_SERVER['PHP_SELF']?>">
    	<fieldset>
        	<legend>Login</legend>
            <div class="formBox">
            	<label for="user">User Name</label>
            	<input type="text" name="user" id="user" value="" class="wide"/>
            </div>
            <div class="formBox">
            	<label for="pass">Password</label>
            	<input type="password" name="pass" id="pass" value="" class="wide"/>
            </div> 
            <br />
            <br />
             <div class="formBox">
            	<label for="url">OR use <a href="http://www.openid.net">openID</a> <img src="img/login-bg.gif" height="16px" width="16px" /> <span id="http">http://</span></label>
            	<input type="text" name="url" id="url" value="" class="wide"/>
                <p id="url" style="float:left;">don't have an openID, then get one <a href="http://www.myopenid.com" title="there are many other providers, but I use this one.">here</a>. Want to have openID for your users, then visit my tutoral <a href="http://imd.edumedia.ca/hard0092/mtm4086/openID/documentationIndexOpenID.html">here</a>. </p>
            </div>
            <div class="formBox buttons">
            	<input type="submit" name="btnLogin" id="btnLogin" value="Login" class="btn"/>
            </div>
        </fieldset>
    </form>

    <form name="signinForm" id="signinForm" method="post" action="<?=$_SERVER['PHP_SELF']?>">
    	<fieldset>
        	<legend>Sign-Up</legend>
            <div class="formBox">
            	<label for="user">User Name</label>
            	<input type="text" name="ruser" id="ruser" value="" class="wide"/>
            </div>
            
            <div class="formBox">
            	<label for="pass">Password</label>
            	<input type="password" name="rpass" id="rpass" value="" class="wide"/>
            </div>
            
            <div class="formBox">
            	<label for="pass">Retype Password</label>
            	<input type="password" name="rrpass" id="rrpass" value="" class="wide"/>
            </div>
            
            <div class="formBox">
            	<label for="pass">Full Name</label>
            	<input type="text" name="rfname" id="rfname" value="" class="wide"/>
            </div>
            
            <div class="formBox">
            	<label for="pass">Email</label>
            	<input type="text" name="remail" id="remail" value="" class="wide"/>
            </div>
            
            <div class="formBox buttons">
            	<input type="submit" name="sup" id="sup" value="Sign-Up" class="btn"/>
            </div>
        </fieldset>
    </form>
     <?php
		}
	?>
    </div>
</div>
</body>
</html>
