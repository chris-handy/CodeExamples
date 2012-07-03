$(document).ready(function(){
    $('#gallery li').each(function(idx) {
        $(this).data('index', (++idx));
    });
    
    $('#gallery').jcarousel({
        animation: 1000,
        buttonNextHTML: '<a href="#" onclick="$.galleria.next(); return false;">next &raquo;</a>',
        buttonPrevHTML: '<a href="#" onclick="$.galleria.prev(); return false;">prev &raquo;</a>',
        wrap: 'both',
        initCallback: initCallbackFunction
    });
    
    function initCallbackFunction(carousel) {
        $('#img').bind('image-loaded',function() {
            var idx =  $('#gallery li.active').data('index') - 3;
            carousel.scroll(idx);
            return false;
        }); 
    };
    
    $('#gallery li img').css('opacity', 0).each(function() {    
        if (this.complete || this.readyState == 'complete') {  $(this).animate({'opacity': 1}, 300) }
        else { $(this).load(function() { $(this).animate({'opacity': 1}, 1000) }); }
    });

    $('#gallery').galleria({
        insert: '#img',
        clickNext: true,
        history: false,
        onImage: function(image, caption, thumb) {
        	image.hide().fadeIn(1000);
            thumb.parent().fadeTo(600, 1).siblings().fadeTo(600, 0.4);
            image.attr('title','Next image »');
            $('#img').trigger('image-loaded');
        },
        onThumb: function(thumb) {
            var $li = thumb.parent();
            $li.hover(function(){$li.fadeTo(200, 1);},function(){$li.not('.active').fadeTo(200, 0.4);})
        }     
    }).find('li:first').addClass('active');

});