menus_jQuery(document).ready(function() {
    menus_jQuery('.sidebar ul li').click(function(){
        var emptySpace = ' ';
        var effect = menus_jQuery(this).attr('data-effect') + emptySpace ;
        var effectDuration = menus_jQuery(this).attr('data-effect-duration') + emptySpace;
        var easeType = menus_jQuery(this).attr('data-ease-type') + emptySpace;
        console.log('effect: '+ effect + 'duration: ' + effectDuration + 'ease type: ' + easeType);
        menus_jQuery('head')
            .append(
                '<style>' +
                    '.extend-effect{'                                 +
                    '-webkit-animation:' + effect + effectDuration + easeType  + ';' +
                    '-moz-animation:' + effect + effectDuration + easeType   + ';' +
                    '-o-animation:' + effect + effectDuration + easeType + ';' +
                    ' }' +
                    '</style>'
            );
    });
    var fixScroll = function(){
        var body = menus_jQuery('body');
        var fixer = 'xtd-body-fix';
            if(!body.hasClass(fixer)){
                body.addClass(fixer);
            }
    };

    var fixNumbering = function(){
        var nr = menus_jQuery('#fb-number-inner')
        if(nr.length > 0){
            nr.remove();
        }
            menus_jQuery('.image-number').prependTo(menus_jQuery('#fancybox-wrap')).wrap('<div id="fb-number-inner"></div>')

    };




    menus_jQuery("a[data-rel=LightBox6]").each(function() { 
        var self= menus_jQuery(this);
        menus_jQuery(this).extendLightbox({
            'padding'           : 10,
            'margin'            : 10,
            'type'              : 'inline',
            'showCloseButton'   : true,
            'showCaption'       : false,
            'showNumbers'       : false,
            'showArrows'        : false,
            'overlayOpacity'    : 0.8,
            'overlayColor'      : '#000000',
            'showNavArrows'     : false,
            'titleShow'         : true,
            'transitionIn'      : 'none',
            'transitionOut'     : 'fade',
            'titlePosition'     : 'outside',
            'autoDimensions'    : false,
            'width'             : 500,
            'height'            : 350,
            'onCleanup'         : function(){
                menus_jQuery('#outside-controls').remove();
                menus_jQuery('#fb-number-inner').remove();
            },
            'onStart'           : function(){
              
               
               
               
            },

            'onComplete'        : function(){
                fixNumbering();
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
                    var ligthboxControls = '<div class="lightbox-controls-inner">' + '<div class="image-number">' + (currentIndex + 1) + ' / ' + currentArray.length + '</div>' + '<div class="lightbox-controls">';
                    var onlyOneImage = '<div class="lightbox-controls-inner"><div class="image-number"></div></div>';

                    switch (currentIndex){
                        case 0:

                            if (lastItem == 0) return onlyOneImage;

                            // show image number and prev arrow
                            if(currentOpts.showNumbers && currentOpts.showArrows) return ligthboxControls + nextControl + '</div></div>';
                            // show image number
                            else if(currentOpts.showNumbers) return ligthboxControls + '</div></div>';
                            // show arrows
                            else if(currentOpts.showArrows) return '<div class="lightbox-controls-inner"><div class="image-number"></div>' + nextControl + '</div>';
                            // show nothing
                            else return '<div class="image-number"></div>';
                            break;
                        case lastItem:
                            // show image number and next arrow
                            if(currentOpts.showNumbers && currentOpts.showArrows) return ligthboxControls + prevControlLast + '</div></div>';
                            // show image number
                            else if(currentOpts.showNumbers) return ligthboxControls + '</div></div>';
                            // show arrows
                            else if(currentOpts.showArrows) return '<div class="lightbox-controls-inner"><div class="image-number"></div>' + prevControlLast + '</div>';
                            // show nothing
                            else return '<div class="image-number"></div>';
                            break;
                        default :
                            // show image number and arrows
                            if(currentOpts.showNumbers && currentOpts.showArrows) return ligthboxControls + prevControl + nextControl + '</div></div>';
                            // show image number
                            else if(currentOpts.showNumbers) return ligthboxControls + '</div></div>';
                            // show arrows
                            else if(currentOpts.showArrows) return '<div class="lightbox-controls-inner"><div class="image-number"></div>' + nextControl + prevControl + '</div>';
                            // show nothing
                            else return '<div class="image-number"></div>';
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



