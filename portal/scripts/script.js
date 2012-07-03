//script.js

  $(document).ready(function(){
	//draggable
/*	$(".dragbar").click(function(){
		$(".libox").draggable({cursor: 'move', helper: 'original', revert: 'invalid', opacity: 0.5});
	 });
	
	//droppable
	$(".ulbox").droppable({
			accept: '.libox',
			activeClass: 'hover',
			drop: function(ev, ui) {
				$(this).append(ui.draggable);
			}
		});*/
						 
 //rss1   
   $("#rssUp").click(function () {
      $("#rssBox").slideUp();
    });
    $("#rssDown").click(function () {
      $("#rssBox").slideDown();
    });
	
 //flickr
    $("#flickrUp").click(function () {
      $("#flickrBox").slideUp();
    });
    $("#flickrDown").click(function () {
      $("#flickrBox").slideDown();
    });

 //rss2
    $("#rss2Up").click(function () {
      $("#rss2Box").slideUp();
    });
    $("#rss2Down").click(function () {
      $("#rss2Box").slideDown();
    });

 //youtube  
    $("#ytUp").click(function () {
      $("#ytBox").slideUp();
    });
    $("#ytDown").click(function () {
      $("#ytBox").slideDown();
    });

 //google search 
    $("#googUp").click(function () {
      $("#googBox").slideUp();
    });
    $("#googDown").click(function () {
      $("#googBox").slideDown();
    });

  });
  
