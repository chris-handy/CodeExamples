<?php
require_once("includes/db.inc.php");
require('includes/class.openid.v3.php');





	//----------------------------OpenID---------------------
 if(isset($_POST['url'])){
		
		$openid = new SimpleOpenID;
		$openid->SetIdentity($_POST['url']);
		$openid->SetTrustRoot('http://' . $_SERVER["HTTP_HOST"] . '/hand0040/mtm4086/');
		$openid->SetRequiredFields(array('email','fullname'));
		$openid->SetOptionalFields(array('dob','gender','postcode','country','language','timezone'));
		if ($openid->GetOpenIDServer()){
			$openid->SetApprovedURL('http://'.$_SERVER["HTTP_HOST"].'/hand0040/mtm4086/portal/index.php'.$_SERVER["PATH_INFO"]);//--Send Response from OpenID server to this script
			$openid->Redirect(); 	//--This will redirect user to OpenID Server
		}else{
			$error = $openid->GetError();
			echo "ERROR CODE: " . $error['code'] . "<br>";
			echo "ERROR DESCRIPTION: " . $error['description'] . "<br>";
		}
		exit;
	}
	else if(isset($_GET['openid_mode']) && $_GET['openid_mode']== 'id_res'){ 	//-- Perform HTTP Request to OpenID server to validate key
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
				$fullName = explode(" ",$f);
				$first = $fullName[0];
				$last = $fullName[1];
				$e = mysql_real_escape_string(trim($_GET['openid_sreg_email']));
				$strSQL1 = "INSERT INTO users(user_name, f_name, l_name, email) VALUES('".$u."', '".$first."', '".$last."', '".$e."' )";
				$RS1 = mysql_query($strSQL1);				
				$_SESSION['first'] = $first;
				$_SESSION['last'] = $last;
				$_SESSION['user_id'] =  uniqid('UU_', true);				
			}else{
				$f = mysql_real_escape_string(trim($_GET['openid_sreg_fullname']));
				$fullName = explode(" ",$f);
				$first = $fullName[0];
				$last = $fullName[1];
				$_SESSION['first'] = $first;
				$_SESSION['last'] = $last;
				$_SESSION['user_id'] =  uniqid('UU_', true);
				header('location: index.php');				
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
	}else if (isset($_GET['openid_mode']) &&  $_GET['openid_mode']== 'cancel'){ //-- User Canceled your Request
		echo "USER CANCELED REQUEST";
	}
	//--------------------------------------------------------

?>