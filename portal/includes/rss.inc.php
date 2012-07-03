<?php
function getFeed($feed_url) {
	
	$content = file_get_contents($feed_url);
	
	$x = new SimpleXmlElement($content);
	
	echo "<ul>";
	$limit = 5;
		foreach($x->channel->item as $entry) {
			if($entry<=$limit){
				echo "
				<li>
				  <a href='$entry->link' title='$entry->title'>" . $entry->title . "</a>
				</li>";
			}else{
				break;
			}
		}
		
	echo "</ul>";
}
?>