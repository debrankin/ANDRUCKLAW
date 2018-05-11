menus_jQuery(document).ready(function() {


    var fixControlPosition = function(){

        var wrap = menus_jQuery('#fancybox-outer');
        var elem2 = menus_jQuery('#outside-controls');


        if(elem2.length > 0 ){
            elem2.remove();
        }
        menus_jQuery('div.lightbox-controls-inner').prependTo(wrap).wrap('<div id="outside-controls"></div> ')
            .css({'top': + Math.round(parseInt((wrap.height() - 65)/2))})
            .removeClass('xtd-hide');

    };



    var fixImageNumber = function(){
        var imageNumber = menus_jQuery('#image-number-inner');
        if (imageNumber.length > 0 ) {
            imageNumber.remove();
        }
        else{
            menus_jQuery('#image-number').appendTo('#fancybox-title-over .image-title').wrap('#image-number-inner');
        }
    }

    menus_jQuery("a[data-rel=LightBox2]").each(function() { 
        var self= menus_jQuery(this);
        menus_jQuery(this).extendLightbox({
            'padding'           : 0,
            'margin'            : 0,
            'type'              : 'iframe',
            'showCaption'       : false,
            'showNumbers'       : false,
            'showArrows'        : false,
            'showCloseButton'   : true,
            'overlayOpacity'    : 0.8,
            'overlayColor'      : '#000000',
            'showNavArrows'     : false,
            'titleShow'         : true,
            'transitionIn'      : 'none',
            'transitionOut'     : 'fade',
            'titlePosition'     : 'outside',
            'autoDimensions'    : false,
            'width'             : 80%,
            'height'            : none,
            'onCleanup'         : function(){
                menus_jQuery('#outside-controls').remove();
            },
            'onComplete'        :function(){
                fixControlPosition();
                fixImageNumber();

            },
            'onStart'           : function(){
               
                
                
                menus_jQuery('#outside-controls').fadeOut(200).remove();

            },
            'onClosed'           : function(){
                menus_jQuery('body').removeClass('xtd-body-fix');
            },
            'titleFormat'       : function(title, currentArray, currentIndex, currentOpts) {
                var clearfix = '<div class="clearfix"></div> ';
                var showControls = function(){
                    var lastItem = currentArray.length - 1;
                    var nextControl = '<div onclick="menus_jQuery.xtd_fancybox.next();" class="lightbox-control-next"></div>';
                    var prevControl = '<div onclick="menus_jQuery.xtd_fancybox.prev();" class="lightbox-control-prev"></div>';
                    var prevControlLast = '<div onclick="menus_jQuery.xtd_fancybox.prev();" class="lightbox-control-prev prev-last"></div>';
                    var ligthboxControls = '<div class="lightbox-controls-inner">' + '<div id="image-number">' + (currentIndex + 1) + ' / ' + currentArray.length + '</div>' + '<div class="lightbox-controls">';
                    var onlyOneImage = '<div class="lightbox-controls-inner"></div>';

                    switch (currentIndex){
                        case 0:

                            if (lastItem == 0) return onlyOneImage;

                            // show image number and prev arrow
                            if(currentOpts.showNumbers && currentOpts.showArrows) return ligthboxControls + nextControl + '</div></div>';
                            // show image number
                            else if(currentOpts.showNumbers) return ligthboxControls + '</div></div>';
                            // show arrows
                            else if(currentOpts.showArrows) return '<div class="lightbox-controls-inner">' + nextControl + '</div>';
                            // show nothing
                            else return '';
                            break;
                        case lastItem:
                            // show image number and next arrow
                            if(currentOpts.showNumbers && currentOpts.showArrows) return ligthboxControls + prevControlLast + '</div></div>';
                            // show image number
                            else if(currentOpts.showNumbers) return ligthboxControls + '</div></div>';
                            // show arrows
                            else if(currentOpts.showArrows) return '<div class="lightbox-controls-inner">' + prevControl + '</div>';
                            // show nothing
                            else return '';
                            break;
                        default :
                            // show image number and arrows
                            if(currentOpts.showNumbers && currentOpts.showArrows) return ligthboxControls + prevControl + nextControl + '</div></div>';
                            // show image number
                            else if(currentOpts.showNumbers) return ligthboxControls + '</div></div>';
                            // show arrows
                            else if(currentOpts.showArrows) return '<div class="lightbox-controls-inner">' + nextControl + prevControl + '</div>';
                            // show nothing
                            else return '';
                            break
                    }
                };

                // if no arrows , no image number , no caption , don't show container
                if(!currentOpts.showArrows && !currentOpts.showNumbers && !currentOpts.showCaption) return clearfix;

                // if 1 image and no caption don't show container
                if((!currentOpts.showCaption || self.attr('title') == '') && currentArray.length - 1 == 0) return clearfix;

                if(currentOpts.showCaption)
                    return '<div id="fancybox-title-over">' + '<div class="image-title">' + (title.length ? title : '') + '</div>' + showControls() + '</div>' + clearfix;
                else
                    return '<div id="fancybox-title-over">' + showControls() + '</div>' + clearfix;

            }
        });
    });
});
