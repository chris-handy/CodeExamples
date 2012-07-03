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
       

<script type="text/javascript">
	$(document).ready(function(){
		$("#commentForm").validate();
	});
</script>
            <div id="getInTouch" class="clearfix">
            	<img src="images/contact_image.png" alt="coffee" />
                <h1>Get In Touch.</h1>
                <p>We love hearing from you. If you have and feed back that you’d like to share, please 
get in touch by filling out this form. By giving us your contact, we’ll be able to keep you
up-to-date of upcoming events and promotions.</p>
			<form id="commentForm" action="http://www.google.com" method="get">
            	<fieldset>
                	<fieldset>
                        <label for="fullname">Name</label>    
                        <input type="text" id="fullname" name="fullname" maxlength="200" class="required"/>
                    </fieldset>
                    <fieldset>
                        <label for="email">Email Address</label>    
                        <input type="text" id="email" name="email" maxlength="200"  class="required email" />
                    </fieldset>
                    <fieldset>
                    	<label for="postalcode">Postal Code/Zip Code</label>  
                    	<input type="text" id="postalcode" name="postalcode" maxlength="200"/>
                    </fieldset>
                    <fieldset>
                        <label for="birthday">Year of Birth</label>  
							<select name="birthday">
								<optgroup label="Year">
									<option value="2000">2000</option>
									<option value="1999">1999</option>
									<option value="1998">1998</option>
									<option value="1997">1997</option>
									<option value="1996">1996</option>
									<option value="1995">1995</option>
									<option value="1994">1994</option>
									<option value="1993">1993</option>
									<option value="1992">1992</option>
									<option value="1991">1991</option>
									<option value="1990">1990</option>
									<option value="1989">1989</option>
									<option value="1988">1988</option>
									<option value="1987">1987</option>
									<option value="1986">1986</option>
									<option value="1985">1985</option>
									<option value="1984">1984</option>
									<option value="1983">1983</option>
									<option value="1982">1982</option>
									<option value="1981">1981</option>
									<option value="1980">1980</option>
									<option value="1979">1979</option>
									<option value="1978">1978</option>
									<option value="1977">1977</option>
									<option value="1976">1976</option>
									<option value="1975">1975</option>
									<option value="1974">1974</option>
									<option value="1973">1973</option>
									<option value="1972">1972</option>
									<option value="1971">1971</option>
									<option value="1970">1970</option>
									<option value="1969">1969</option>
									<option value="1968">1968</option>
									<option value="1967">1967</option>
									<option value="1966">1966</option>
									<option value="1965">1965</option>
									<option value="1964">1964</option>
									<option value="1963">1963</option>
									<option value="1962">1962</option>
									<option value="1961">1961</option>
									<option value="1960">1960</option>
									<option value="1959+">1959+</option>
								</optgroup>
							</select>
                    </fieldset>
                    <fieldset>
                        <label for="gender">Gender</label>
                        <input type="radio"  name="gender" value="Male" />Male
                        <input type="radio"  name="gender" value="Female" />Female
                    </fieldset>
                    <fieldset>
                        <label for="message">Message</label>
                        <textarea id="message" cols="40" rows="10" class="required" ></textarea>
                    </fieldset>
                	<button type="submit" id="submit" value="SEND" class="send" />
                
                </fieldset>
            </form>
		</div>
    	
        <ul id="address">
        	<li><h4>HEAD OFFICE</h4></li>
            <li><span id="one">healthy</span><span id="two">living</span></li>
            <li><p>601 West 26th Street</p></li>
            <li><p>New York, NY 10001</p></li>
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
            <span class="copyright">&copy; 2010 healthyliving. All rights reserved.</span>
        </div>
        
    	<div id="contact-twitter" class="clearfix">
            <h4>LATEST TWEET</h4>
            <span>healthy-living:</span><ul id="twitter_update_list"><li></li></ul>
            <a href="http://www.twitter.com/chrs_h" class="follow">+ FOLLOW US ON TWITTER</a>
            <ul>
                <li><img src="images/rss.png" alt="rss" height="18px" width="19px"/> </li>
                <li><img src="images/facebook.png" alt="facebook" height="18px" width="19px"/></li>
                <li><img src="images/stumbleupon.png" alt="stumbleupon" height="19px" width="19px"/></li>
                <li><img src="images/diggman.png" alt="digg" height="19px" width="19px"/></li>
            </ul>              
       </div>
    </div>
<script type="text/javascript" src="scripts/blogger.js"></script>
<script type="text/javascript" src="http://twitter.com/statuses/user_timeline/chrs_h.json?callback=twitterCallback2&amp;count=1"></script>
</body>
</html>