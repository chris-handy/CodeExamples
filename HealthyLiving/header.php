<?php
/**
 * @package WordPress
 * @subpackage Default_Theme
 */
?>
<!--HEADER AREA-->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Healthy Living</title>
<link href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" rel="stylesheet" />
<script src="<?php bloginfo('template_directory'); ?>/scripts/jquery-1.4.min.js" type="text/javascript"> </script>
<script src="<?php bloginfo('template_directory'); ?>/scripts/jquery-ui-1.7.2.custom.min.js" type="text/javascript"> </script>
<script src="<?php bloginfo('template_directory'); ?>/scripts/validate.js" type="text/javascript"> </script>
<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/scripts/jquery.galleria.js"></script>
<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/scripts/jquery.jcarousel.pack.js"></script>
<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/scripts/gallery-function.js"></script>

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
            <li><a id="homeNav" href="<?php echo get_permalink(2);?>">home.</a></li>
            <li><a id="blogNav" href="index.php/blog">blog.</a></li>
            <li><a id="recipesNav" href="index.php/recipes">recipes.</a></li>
            <li><a id="galleryNav" href="index.php/gallery">gallery.</a></li>
            <li><a id="contactNav" href="index.php/contact">contact.</a></li>
            <li><a id="aboutNav" href="index.php/about-2">about.</a></li>
        </ul>
       </div>     
       