<?php


	if( isset($_SESSION['user_id'])&& isset($_SESSION['first']) && isset($_SESSION['last']) ){
		
		echo '<span id="logout"><a href="logout.php" title="logout">Logout</a></span>';
	}
	?>


  <?php
		if(isset($errMsg)){//--check for errors
			echo '<p class="error">';
			echo $errMsg;
			echo '</p>';
		}
		//--only  show the login form IF the user is NOT logged in
		if( isset($_SESSION['user_id']) && isset($_SESSION['first']) && isset($_SESSION['last']) ){
			echo "<p id='welcome'>Welcome to Port-All, ".$_SESSION['first']." ".$_SESSION['last'].". </p>";
		
		}else{
	?>
  <form name="loginForm" id="loginForm" method="post" action="<?=$_SERVER['PHP_SELF']?>">
    <div id="fieldset">
    <legend>Login</legend>
    <div class="formBox">
      <label for="url"><img src="img/login-bg.gif" height="16px" width="16px" /> <span id="http">http://</span></label>
      <input type="text" name="url" id="url" value="" class="wide"/>
      <input type="submit" name="btnLogin" id="btnLogin" value="Login" class="btn"/>
    </div>
    </div>
  </form>
<?php
	}
	?>

