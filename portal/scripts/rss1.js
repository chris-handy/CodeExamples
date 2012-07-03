// rss1.js

var timer;  
   
$(document).ready(function() {  
  
	getSearch();  
  
});  
   
function getSearch()  {  
		clearTimeout(timer);  
		//var results;  
		var feed = "http://www.engadget.com/rss.xml";  
		$.post("includes/curl.inc.php", {query: feed},  function(xml){  
							alert(xml);
			$('item', xml).each(function(i){  
								 
				for(x=0; x<item.length;x++){
					var title = document.createTextNode($(this).find("title").text());  
					var link = document.createTextNode($(this).find("link").text()); 
					var text = document.createTextNode($(this).find("description").text());
					var div = document.createElement('div');
					var span = document.createElement('span');
					var span2 = document.createElement('span');
					var p = document.createElement('p');
					div.appendChild(span);
					div.appendChild(span2);
					div.appendChild(p);
					span.appendChild(title);
					span2.appendChild(link);
					p.appendChild(text);
					('#rssBox').appendChild(div);
				}
				
			});  
	  
		});  
	  
		timer = setTimeout(getSearch, 30000);  
	}  


/*function getSearch() {
	clearTimeout(timer);  
	var feed = "http://www.engadget.com/rss.xml";
	//clear the content in the div for the next feed.
	$("#rssBox").empty();
 
	//use the JQuery get to grab the URL from the selected item, put the results in to an argument for parsing in the inline function called when the feed retrieval is complete

 	$.get("includes/curl.inc.php", {query: feed},  function(xml){  
				 alert(xml);	
		//find each 'item' in the file and parse it
		$(query).find('item').each(function() {
 
			//name the current found item this for this particular loop run
			var $item = $(this);
			// grab the post title
			var title = $item.find('title').text();
			// grab the post's URL
			var link = $item.find('link').text();
			// next, the description
			var description = $item.find('description').text();
			//don't forget the pubdate
			var pubDate = $item.find('pubDate').text();
 
			// now create a var 'html' to store the markup we're using to output the feed to the browser window
			var html = "<div class=\"entry\"><h2 class=\"postTitle\">" + title + "<\/h2>";
			html += "<em class=\"date\">" + pubDate + "</em>";
			html += "<p class=\"description\">" + description + "</p>";
			html += "<a href=\"" + link + "\" target=\"_blank\">Read More &raquo;<\/a><\/div>";
 
			//put that feed content on the screen!
			alert(html);
			//$('#rssBox').append(html);  
		});
	 });
 timer = setTimeout(getSearch, 30000);  
};*/