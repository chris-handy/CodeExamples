<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Healthy Living</title>
<link href="style.css" type="text/css" media="screen" rel="stylesheet" />
<script src="scripts/jquery-1.4.min.js" type="text/javascript"> </script>
<script src="scripts/jquery-ui-1.7.2.custom.min.js" type="text/javascript"> </script>
<script src="scripts/validate.js" type="text/javascript"> </script>
<script type="text/javascript" src="scripts/jquery.galleria.js"></script>
<script type="text/javascript" src="scripts/jquery.jcarousel.pack.js"></script>
<script type="text/javascript" src="scripts/gallery-function.js"></script>

<script type="text/javascript">
	$(document).ready(function(){
		$(function() {
			$("#tabs").tabs({event:"mouseover"}).tabs('rotate', 5000, true);
		}); 
		
	});
</script>

</head>

<body>
    <div id="wrapper" class="clearfix">
    	<div id="header" class="clearfix">
        	<h1>healthyliving.</h1>
            <div id="searchBox">
            	<form action="#">
                	<fieldset>
						<ul>
							<li><input type="text" id="search" name="search" value="SEARCH" /></li>
							<li><button type="submit" class="go"></button></li>
						</ul>
                    </fieldset>
                </form>
            </div>
     
        
        <ul id="navigation" class="clearfix">
            <li><a id="homeNav" href="index.php">home.</a></li>
            <li><a id="blogNav" href="wholehealth.php">blog..</a></li>
            <li><a id="recipesNav" href="eatingwell.php">recipes.</a></li>
            <li><a id="galleryNav" href="beinspired.php">gallery.</a></li>
            <li><a id="contactNav" href="getintouch.php">contact.</a></li>
            <li><a id="aboutNav" href="aboutus.php">about.</a></li>
        </ul>
       </div>     

    
         <div id="tabs">
            <ul id="tabNavigation">
                <li>
                    <h3>Features</h3>
                </li>
                <li class="tabArea">
                    <a href="#tabs-1" id="newsItem01">
                    <strong>.01 Whole Body Challenge</strong>
                    <span>+ read more &#187;</span>
                    </a>
                </li>
                <li class="tabArea">
                    <a href="#tabs-2" id="newsItem02">
                    <strong>02. New Year's Cleanse</strong>
                    <span>+ read more &#187;</span>

                    </a>
                </li>
                <li>
                    <a href="#tabs-3" id="newsItem03">
                    <strong>03. Enviro Babies</strong>
                    <span>+ read more &#187;</span>
                    </a>
                </li>

            </ul>
            <div id="tabs-1" class="tabContent">
                <img class="mainNewsImage" src="images/featured_image.jpg" width="599" height="263" alt="Ottawa River" />
                <p>Whole Body Challenge</p>
            </div>
            <div id="tabs-2" class="tabContent">
                <img class="mainNewsImage" src="images/featured_image.jpg" width="599" height="263" alt="Montr&eacute;al Building" />
                <p>New Year's Cleanse</p>
            </div>
            <div id="tabs-3" class="tabContent">
                <img class="mainNewsImage" src="images/featured_image.jpg" width="599" height="263" alt="Qu&eacute;bec City Building" />
                <p>Enviro Babies</p>
            </div>
        </div>
        
        <ul id="callToActions" class="clearfix">
        	<li id="latestBlog">
            	<h4>LATEST BLOG.</h4>
                <h5>The Sweet Life</h5>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur eleifend fermentum velit lobortis vulputate. Sed consequat velit non nibh imperdiet dapibus. Nunc et odio eget nunc cursus elementum. Suspendisse accumsan</p>
                <a href="#">+ CONTINUE READING</a>
            </li>
            
            <li id="featuredRecipes">
            	<h4>FEATURED RECIPES</h4>
                <ul>
                	<li>
                    	<img src="images/lemons.png" alt="lemons" />
                    	<p>Lemon, Sesame &amp; Garlic Hummus</p>
                        <span>SERVES 4, TAKES 10 MINUTES</span>
                        <a href="#">+ COMPLETE RECIPE</a>
                    </li>
                	<li>
                    	<img src="images/avocado.png" alt="avocado" />
                    	<p>Chilled Avocado Soup</p>
                        <span>SERVES 4, TAKES 10 MINUTES</span>
                        <a href="#">+ COMPLETE RECIPE</a>
                    </li>
                    
                    <li>
                    	<img src="images/salad.png" alt="salad" />
                    	<p>Salad with Egg, Nuts &amp; Veggies</p>
                        <span>SERVES 4, TAKES 10 MINUTES</span>
                        <a href="#">+ COMPLETE RECIPE</a>
                    </li>
                </ul>
            </li>
            
            <li id="newsletter">
            	<h4>GET OUR NEWSLETTER</h4>
            	<p>Weekly ideas, recipes, and tips for a balanced, healthy lifestyle.</p>
            	<form action="#">
                	<fieldset>
                        <label for="name">First Name</label>
                       <input type="text" id="name" name="name"/>
                        <label for="email">Email Address</label>
                        <input type="text" id="email" name="email"/>
                        <button type="submit" value="SIGN UP" class="signup" />
                     </fieldset>
                </form>
            </li>
        </ul>
 

        <div id="footer" class="clearfix">
        	<ul id="categories">
            	<li><h5>CATEGORIES</h5></li>
            	<li><a href="#">Home.</a></li>
                <li><a href="#">Whole Health.</a></li>
                <li><a href="#">Green Living.</a></li>
                <li><a href="#">Eating Well.</a></li>
                <li><a href="#">Be Inspired.</a></li>
                <li><a href="#">About us.</a></li>
            </ul>
            <ul id="customerservice">
            	<li><h5>CUSTOMER SERVICE</h5></li>
            	<li><a href="#">Subscriptions.</a></li>
                <li><a href="#">Privacy Policy.</a></li>
                <li><a href="#">Copyright.</a></li>
                <li><a href="#">Terms of Use.</a></li>
            </ul>
            <ul id="aboutus">
            	<li><h5>ABOUT US</h5></li>
            	<li><a href="#">Our Team.</a></li>
                <li><a href="#">Advertise With Us.</a></li>
                <li><a href="#">Contact Us.</a></li>
            </ul>
            <ul id="eventspromotions">
            	<li><h5>EVENTS &amp; PROMOTIONS</h5></li>
            	<li><a href="#">Events &amp; Promotions.</a></li>
                <li><a href="#">Free Stuff.</a></li>
                <li><a href="#">Sponsors.</a></li>
                <li><a href="#">Marketplace.</a></li>
            </ul>
            
            <div id="twitter">
            	<h4>LATEST TWEET</h4>
                <span>healthy-living:</span> <ul id="twitter_update_list"><li></li> </ul>
				<a href="http://twitter.com/chrs_h" class="follow">+ FOLLOW US ON TWITTER</a>
                <ul>
                    <li><img src="images/rss.png" alt="rss" height="18px" width="19px"/> </li>
                    <li><img src="images/facebook.png" alt="facebook" height="18px" width="19px"/></li>
                    <li><img src="images/stumbleupon.png" alt="stumbleupon" height="19px" width="19px"/></li>
                    <li><img src="images/diggman.png" alt="digg" height="19px" width="19px"/></li>
                </ul>              
            </div>
            <span class="copyright">&copy; 2010 healthyliving. All rights reserved.</span>
        </div>
    
    </div>
<script type="text/javascript" src="scripts/blogger.js"></script>
<script type="text/javascript" src="http://twitter.com/statuses/user_timeline/chrs_h.json?callback=twitterCallback2&amp;count=1"></script>
</body>
</html>