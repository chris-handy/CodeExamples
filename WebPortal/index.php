<?php include ('includes/openid.inc.php'); ?>
<?php include ('includes/curl.inc.php');?>
<?php include ('includes/rss.inc.php');?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Portal</title>
<script src="scripts/jquery-1.3.2.min.js" language="javascript" type="text/javascript"> </script>
<script src="scripts/ui.core.js" language="javascript" type="text/javascript"> </script>
<script src="scripts/ui.draggable.js" language="javascript" type="text/javascript"> </script>
<script src="scripts/ui.droppable.js" language="javascript" type="text/javascript"> </script>
<script src="scripts/script.js" language="javascript" type="text/javascript"> </script>
<script src="http://www.google.com/uds/api?file=uds.js&v=1.0&key=ABQIAAAAzHvm_f23U5xKgbnXqpk2kxTPq-ksfQbiycbDAnieDuB8PnAB9RRAeu1jul-Cr2xIXPkWCserCawq2w" type="text/javascript"></script>
<script src="http://www.google.com/uds/solutions/videosearch/gsvideosearch.js"   type="text/javascript"></script>
<script language="javascript" type="text/javascript" src="http://www.google.com/jsapi?key=ABQIAAAAzHvm_f23U5xKgbnXqpk2kxTPq-ksfQbiycbDAnieDuB8PnAB9RRAeu1jul-Cr2xIXPkWCserCawq2w"> </script>

<link rel="stylesheet" href="includes/style.css" media="screen" type="text/css" />
<link rel="stylesheet" href="includes/googlesearch.css" media="screen" type="text/css"/>
<link rel="stylesheet" href="includes/youtube.css" media="screen" type="text/css"  />
<!--<link href="http://www.google.com/uds/solutions/videosearch/gsvideosearch.css"    rel="stylesheet" type="text/css"/>-->
</head>
<body>

<div id="wrapper">
<div id="header"><?php include('includes/header.php'); ?> </div>
<div id="nav">
<ul>
<li class="home"><a href="#">Home</a></li>
<li class="mail"><a href="#">Mail</a></li>
<li class="video"><a href="#">Video</a></li>
<li class="bank"><a href="#">Bank</a></li>
</ul>
</div>

<div id="content" class="clearfix">
<div id="A">
  <ul class="ulbox">
  <li id="flickr" class="libox">
      <?php
      if( isset($_SESSION['user_id']) && isset($_SESSION['first'])&& isset($_SESSION['last']) ){
		  
		  echo '<span class="dragbar">Flickr  Search&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span id="flickrDown"><img src="img/downarrow.png"></span>&nbsp;<span id="flickrUp"><img src="img/uparrow.png"></span></span>';
		  echo '<div id="flickrBox" class="container">';

			function do_search($tag){
				$tag=urlencode($tag);
				
				#Insert your own flickr API key here
				$api_key="039920f1e3ebfacd81612be0307c3eb6";
				$per_page="5";
				$url="http://api.flickr.com/services/rest/?method=flickr.photos.search&api_key={$api_key}&tags={$tag}&per_page={$per_page}";
				$feed=getResource($url);
				$xml=simplexml_load_string($feed);
			
				print "<p>Total number of photos for {$tag}: {$xml->photos['total']}</p>";
				
				#http://flickr.com/services/api/misc.urls.html
				#http://farm(farm-id}.static.flickr.com/{server-id}/{id}_secret}.jpg
				foreach($xml->photos->photo as $photo){
					$title= $photo['title'];
					$farmid=$photo['farm'];
					$serverid= $photo['server'];
					$id= $photo['id'];
					$secret= $photo['secret'];
					$owner= $photo['owner'];
					$thumb_url= "http://farm{$farmid}.static.flickr.com/{$serverid}/{$id}_{$secret}_t.jpg";
					$page_url = "http://www.flickr.com/photos/{$owner}/{$id}";
					$image_html = "<a href='{$page_url}'><img alt='{$title}' src='{$thumb_url}'/></a>";
					print "<p>$image_html</p>";
				}
			
			}
			//	$content=file_get_contents($url);
		if(isset($_GET['tag'])){
			
			?>
			<form action="<?php echo $_SERVER['PHP_SELF']?>" method="get">
			<p>Search for photos with the following tag:
			<input type="text" size="20" name="tag" /> <input type="submit" value="Search!" /></p>
			</form>
			<?php
            do_search($_GET['tag']);
		}else{
			?>
			<form action="<?php echo $_SERVER['PHP_SELF']?>" method="get">
			<p>Search for photos with the following tag:
			<input type="text" size="20" name="tag" /> <input type="submit" value="Search!" /></p>
			</form>
			<?php
		}
			
			 echo '</div>';
		 }else{   
			  echo 'Please Login to view the Flickr';
		 }
	  ?>
    </li>
    <li id="rss1" class="libox">
      <?php
      if( isset($_SESSION['user_id']) && isset($_SESSION['first'])&& isset($_SESSION['last']) ){
		  echo '<span class="dragbar">Engadget RSS Feed&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span id="rssDown"><img src="img/downarrow.png"></span>&nbsp;<span id="rssUp"><img src="img/uparrow.png"></span></span>';
		  echo '<div id="rssBox" class="container">';

		 getFeed("http://www.engadget.com/rss.xml");
		  echo '</div>';
	  }else{
	  echo 'Please Login to view the RSS Feed';
	 	 }
	  ?>
    </li>
  </ul>
</div>
<div id="B">
  <ul class="ulbox">
  	<li id="youtube" class="libox">
      <?php
      if( isset($_SESSION['user_id']) && isset($_SESSION['first'])&& isset($_SESSION['last']) ){
	  
	  echo '<span class="dragbar">YouTube  Search&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span id="ytDown"><img src="img/downarrow.png"></span>&nbsp;<span id="ytUp"><img src="img/uparrow.png"></span></span>';
	  echo '<div id="ytBox" class="container">';
	    ?>
<script type="text/javascript">
  var mySearchControl;
  
   function LoadVideoSearch() {

      // establish default tags ... these will appear below the search box
      var defaultTags = [
	    { query : "panic attack expert drums gs", label : "RB2 - Panic Attack" },
        { query : "Me and Chris playing In the Middle on Expert chris sean drums guitar rock band", label : "RB2-In The Middle" },
		{ query: "pretty kitty"}
        
      ];

      // request twoRowMode
	  //twoRowMode true means use the width of the container to calculate
	//twoRowMode false means use the largeResultSet setting
	
	//largeResultSet true means up to 8 results
	//largeResultSet false means up to 4 results
      var options = {
        twoRowMode : true
      };

      // create a new GSvideoSearchControl
      mySearchControl = new GSvideoSearchControl(document.getElementById("searchControl"), defaultTags, null, null, options);
  }
  /**
   * Arrange for LoadVideoSearch to run once the page loads.
   */
  GSearch.setOnLoadCallback(LoadVideoSearch);

</script>
  <div id="searchControl">Loading video search...</div>
  <?php
	  echo '</div>';
	  }else{
	   
	  echo 'Please Login to view the Youtube Search';
	  }
	  ?>
    </li>
    <li id="rss2" class="libox">
      <?php
      if( isset($_SESSION['user_id']) && isset($_SESSION['first'])&& isset($_SESSION['last']) ){
	  
	  echo '<span class="dragbar">Joystiq RSS Feed&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span id="rss2Down"><img src="img/downarrow.png"></span>&nbsp;<span id="rss2Up"><img src="img/uparrow.png"></span></span>';
	  echo '<div id="rss2Box" class="container">';

		 getFeed("http://www.joystiq.com/rss.xml");

	  echo '</div>';
	  }else{
	   
	  echo 'Please Login to view the RSS Feed';
	  }
	  ?>
    </li>
  </ul>
 </div>
 <div id="C">
  <ul class="ulbox">
    <li id="google" class="libox">
      <?php
      if( isset($_SESSION['user_id']) && isset($_SESSION['first'])&& isset($_SESSION['last']) ){
	  
	  echo '<span class="dragbar">Google Web Search&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span id="googDown"><img src="img/downarrow.png"></span>&nbsp;<span id="googUp"><img src="img/uparrow.png"></span></span>';
	  echo '<div id="googBox" class="container">';
	  ?>
      <script>
google.load("search", "1");
function initialize() {
        var searchControl = new google.search.SearchControl(null);
		//searchControl.addSearcher(new google.search.LocalSearch());
		searchControl.addSearcher(new google.search.WebSearch());
		//searchControl.addSearcher(new google.search.VideoSearch());
		//searchControl.addSearcher(new google.search.NewsSearch());
		//searchControl.addSearcher(new google.search.ImageSearch());
		//searchControl.addSearcher(new google.search.BookSearch());
		//searchControl.addSearcher(new google.search.PatentSearch());
		
		var drawOptions = new google.search.DrawOptions();
		drawOptions.setDrawMode(google.search.SearchControl.DRAW_MODE_LINEAR);
		//drawOptions.setDrawMode(google.search.SearchControl.DRAW_MODE_TABBED);
		
/*	var options = new google.search.SearcherOptions();
		options.setExpandMode(google.search.SearchControl.EXPAND_MODE_OPEN);
		searchControl.addSearcher(new google.search.VideoSearch(), options);
		
		options = new google.search.SearcherOptions();
		options.setExpandMode(google.search.SearchControl.EXPAND_MODE_PARTIAL);
		searchControl.addSearcher(new google.search.NewsSearch(), options);*/
		
	/*var siteSearch = new google.search.WebSearch();
			siteSearch.setUserDefinedLabel("AlgonquinCollege.com");
		siteSearch.setUserDefinedClassSuffix("siteSearch");
		siteSearch.setSiteRestriction("algonquincollege.com");
		searchControl.addSearcher(siteSearch);*/
		
		searchControl.setOnKeepCallback(this, MyKeepHandler);
		
		searchControl.draw(document.getElementById("searcher"), drawOptions);
		searchControl.execute("macs suck");
      }
function MyKeepHandler(result) {
  var node = result.html.cloneNode(true);
  var savedResults = document.getElementById("Saved_results");
  savedResults.appendChild(node);
}
google.setOnLoadCallback(initialize);

</script>
	 <div id="searcher"> </div>
	<div id="content"></div>
	<div id="Search_result"></div>
	<div id="Saved_results"></div>
    <?php
	  echo '</div>';
	  }else{
	   
	  echo 'Please Login to view the Google Search';
	  }
	  ?>
    </li>
  </ul>
  </div>
</div>
<div id="footer">
<span>&copy; 2009 Port-All Inc. </span>
</div>
</div>

</body>
</html>


