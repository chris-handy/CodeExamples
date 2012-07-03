<?php
require_once("Includes/db.inc.php");
require_once("Includes/dropDownList.php");
session_start();


if(isset($_POST['voteBtn']) ){
	$selected = $_POST['questions'];
	$address = $_SERVER['REMOTE_ADDR'];
	$useragent = $_SERVER['HTTP_USER_AGENT'];
	$time = date('Y-m-d H:i:s');
	$questionid = $_POST['question_id'];
	$answer = $_POST['answer'];
	
	
	$strSQL = "INSERT INTO responses (ip_address, response_time, user_agent, answer, question_id)
		VALUES ('$address', '$time', '$useragent', '$answer', '$questionid')";
	$RS = mysql_query($strSQL, $oConn);

	
	$date = time()+60*60*24*30;
	$name = "jibberish" . $questionid;
	setcookie($name, 0, $date);
	$_SESSION[$name] = $date;
}else{

	//question
		$strSQL = "SELECT * 
						FROM questions 
						ORDER BY RAND() 
						LIMIT 1";
		$RS = mysql_query($strSQL, $oConn);
		$qRow = mysql_fetch_array($RS);
		$question = mysql_real_escape_string($qRow['question_txt']);
		$questionid = $qRow['question_id'];
		
		$name = "jibberish" . $questionid;

}			

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>VOTE PAGE</title>
<?php
include_once("include.css.php");
?>
<script src="includes/jquery-1.2.3.pack.js" type="text/javascript"> </script>
<script>
$(document).ready(
		function(){
			
			$('span.number').each(
				function(){
					var Votes = $(this).text();
					
					var parts = Votes.split('/');
					var w = Math.round(parseInt(parts[0]) / parseInt(parts[1]) * 280);
					
					$(this).animate({ 
				        width: w
					});
					
				}
			)
		}
	);
</script>

  <style>
		*{
			padding:0;
			margin:0;
			border:0;
		}
		#formBox, #formBox2{
			width:300px;
			background-color:#eee;
			border: 1px solid #000;
		}
		p.question{
			font: bold 16px Arial, Helvetica, sans-serif;
			padding: 10px 10px 0 10px;
		}
		#formBox li{
			list-style:none;
			padding: 4px 10px;
			width: 280px;
		}
		#formBox2 li{
			padding:4px, 10px;
			margin: 40px;
		}
		li span.answer{
			display: block;
			font: normal 14px Arial, Helvetica, sans-serif;
			margin: 10px;
		}
		li span.amount{
			display:block;
			font: bold 12px/16px Arial, Helvetica, sans-serif;
			border: 1px solid #003366;
			background-color: #fff;
			color:#FFCC33;
			margin: 10px;
		}
		li span.amount span.number{
			display:block;
			width: 1px;
			background-color: #0066CC;
		}
	</style>
</head>
<body>
<div id="wrapper">
<!--DISPLAY FORM-->
	<?php if(!isset($_SESSION[$name]) || !isset($_COOKIE[$name]) ){?>
  	 		<form name="voteform" id="voteform" action="<?=$_SERVER['PHP_SELF']?>" method="post">
            <input type="hidden" name="question_id" id="question_id" value="<?=$questionid?>" />
            	<fieldset>
                    <div id="formBox2">
                    	<label for="question"><?='<h3>' . $question . '</h1>'; ?></label>
                        <?php
						
						$strSQL1 = "SELECT a.answer_val, a.answer_id
						FROM answers as a
						WHERE a.question_id = $questionid";
						$RS1 = mysql_query($strSQL1, $oConn);
					
						while($aRow=mysql_fetch_array($RS1) ){
								$answer = mysql_real_escape_string($aRow['answer_val']);
								$answerid = $aRow['answer_id'];
								echo '<p>';
								echo '<input type="radio" name="answer" id="answer" value=' . $answer . " />";
								echo '<label id="answer">' . $answer . '</label>';
								echo '</p>';
							}
					
						?>
                    </div>  

                     <div class="btn">
                            <input type="submit" name="voteBtn" id="voteBtn" value="Vote" />
                     </div>

           		</fieldset>
            </form>
          
</div> <!--wrapper ends-->
<?php }else{ ?>
<!-- RESULTS -->
<div id="formBox">
	<label for="question"><?= '<h3>' . $question . '</h1>'; ?></label>
	<?php
	$strSQL2 = "SELECT question_id 
						FROM responses 
						WHERE question_id = $questionid";
    $RS2 = mysql_query($strSQL2, $oConn);
	
	$allVotes = mysql_num_rows($RS2);

	
	$strSQL53 = "SELECT COUNT(question_id) AS cnt, answer
    FROM responses 
    WHERE question_id=$questionid
    GROUP BY answer
    ORDER BY answer";
	$RS53 = mysql_query($strSQL53, $oConn);
	

	while($putRow=mysql_fetch_array($RS53) ){
	echo '<ul>';
	echo '<li>';
	echo  $putRow['answer'];
	echo '<span class="amount"><span class="number">' . $putRow[0] . '/' . $allVotes . '</span></span>';
	echo '</li>';
	echo '</ul>';
	}
}
	

?>
</div>
</body>
</html>
