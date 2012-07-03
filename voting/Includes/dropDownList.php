<?php
//dropDownList.php

function createDropDown($records, $defaultValue=0, $grouping=false, $nm="list", $blankOption="", $className=""){
	/**
	create an HTML select tag from the $records submitted
	The $records could be an array or a recordset
	NB: It is assumed that the list is already sorted according to whatever grouping is desired.
	The default value will be checked for each option and if it matches then selected="selected" will be added
	NB: the $defaultValue does not currently support an array of values
	If $grouping is true then a third field will be looked at for the grouping and its value used as the <optgroup label="">
	$nm will be used as the name and id for the drop down list
	If $blankOption is not empty then an initial <option> tag with the value 0 will be added with this string as the label
	**/
	echo '<select name="' . $nm . '" id="' . $nm . '" class="' . $className . '">';
	
	if($blankOption != ""){
		echo '<option value="0" class="initialOption">' . htmlspecialchars($blankOption) . '</option>' . "\n";	
	}
	
	if( is_array($records)){
		//it is an array that we are looping through
		//check to make sure that grouping is possible... there needs to be a third field in the array
		if($grouping){
			if( sizeof($records) > 0 && sizeof($records[0]) < 3){
				$grouping = false;	
			}
		}
		$firstGroup = true;
		$currentGroup = "The current group should never be equal to this string. If it is then someone really missed the concept of what an optgroup is.";
		foreach($records as $key => $items){
			//		$items is an array that could have two or three values (three for grouping)
			if($grouping){
				if( $currentGroup != $items[2] ){
					if( $firstGroup == false){
						echo '</optgroup>' . "\n";	
					}
					echo '<optgroup label="' . $items[2] . '" >' . "\n";	
					$firstGroup = false;
					$currentGroup = $items[2];
				}
			}
			echo "\t" . '<option value="' . $items[0] . '" ';
			if($items[0] == $defaultValue){
				echo ' selected="selected" ';	
			}
			echo '>';
			echo htmlspecialchars($items[1]);
			echo '</option>' . "\n";
		}
		//when finished looping we need to close the last optgroup if one was opened
		if($grouping){
			echo '</optgroup>' . "\n";	
		}
	}else{
		//it is a mysql recordset
		
		if($grouping){
			if( mysql_num_rows($records) > 0 && mysql_num_fields($records) < 3){
				$grouping = false;	
			}
		}
		$firstGroup = true;
		$currentGroup = "The current group should never be equal to this string. If it is then someone really missed the concept of what an optgroup is.";
		while($items = mysql_fetch_array($records)){
			//		$items is an array that could have two or three values (three for grouping)
			if($grouping){
				if( $currentGroup != $items[2] ){
					if( $firstGroup == false){
						echo '</optgroup>' . "\n";	
					}
					echo '<optgroup label="' . $items[2] . '" >' . "\n";	
					$firstGroup = false;
					$currentGroup = $items[2];
				}
			}
			echo "\t" . '<option value="' . $items[0] . '" ';
			if($items[0] == $defaultValue){
				echo ' selected="selected" ';	
			}
			echo '>';
			echo htmlspecialchars($items[1]);
			echo '</option>' . "\n";
		}
		//when finished looping we need to close the last optgroup if one was opened
		if($grouping){
			echo '</optgroup>' . "\n";	
		}
		
	}
	echo '</select>';
}
?>