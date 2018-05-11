 // ----------------------------------------------------------------------------
 // Vegas – Fullscreen Backgrounds and Slideshows with jQuery.
 // v1.3.3 - released 2013-09-03 13:27
 // Licensed under the MIT license.
 // http://vegas.jaysalvat.com/
 // ----------------------------------------------------------------------------
 // Copyright (C) 2010-2013 Jay Salvat
 // http://jaysalvat.com/
 // ----------------------------------------------------------------------------


 
 
(function(menus_jQuery) {
    var menus_jQuerybackground = menus_jQuery("<img />").addClass("vegas-background"), menus_jQueryoverlay = menus_jQuery("<div />").addClass("vegas-overlay"), menus_jQueryloading = menus_jQuery("<div />").addClass("vegas-loading"), menus_jQuerycurrent = menus_jQuery(), paused = null, backgrounds = [], step = 0, delay = 5e3, walk = function() {}, timer, methods = {
        init: function(settings) {
            var options = {
                src: getBackground(),
                align: "center",
                valign: "center",
                fade: 0,
                loading: true,
                load: function() {},
                complete: function() {}
            };
            menus_jQuery.extend(options, menus_jQuery.vegas.defaults.background, settings);
            if (options.loading) {
                loading();
            }
            var menus_jQuerynew = menus_jQuerybackground.clone();
            menus_jQuerynew.css({
                position: "fixed",
                left: "0px",
                top: "0px"
            }).bind("load", function() {
                if (menus_jQuerynew == menus_jQuerycurrent) {
                    return;
                }
                menus_jQuery(window).bind("load resize.vegas", function(e) {
                    resize(menus_jQuerynew, options);
                });
                
                var supportsOrientationChange = "onorientationchange" in window,
                    orientationEvent = supportsOrientationChange ? "orientationchange" : "resize";
                if(window.addEventListener) { 
                    window.addEventListener("orientationchange", function() {
                        resize(menus_jQuerynew, options);
                    }, false);
                }
                                
                if (menus_jQuerycurrent.is("img")) {
                    menus_jQuerycurrent.stop();
                    menus_jQuerynew.hide().insertAfter(menus_jQuerycurrent).fadeIn(options.fade, function() {
                        menus_jQuery(".vegas-background").not(this).remove();
                        menus_jQuery("body").trigger("vegascomplete", [ this, step - 1 ]);
                        options.complete.apply(menus_jQuerynew, [ step - 1 ]);
                    });
                } else {
                    menus_jQuerynew.hide().prependTo("body").fadeIn(options.fade, function() {
                        menus_jQuery("body").trigger("vegascomplete", [ this, step - 1 ]);
                        options.complete.apply(this, [ step - 1 ]);
                    });
                }
                menus_jQuerycurrent = menus_jQuerynew;
                resize(menus_jQuerycurrent, options);
                if (options.loading) {
                    loaded();
                }
                menus_jQuery("body").trigger("vegasload", [ menus_jQuerycurrent.get(0), step - 1 ]);
                options.load.apply(menus_jQuerycurrent.get(0), [ step - 1 ]);
                if (step) {
                    menus_jQuery("body").trigger("vegaswalk", [ menus_jQuerycurrent.get(0), step - 1 ]);
                    options.walk.apply(menus_jQuerycurrent.get(0), [ step - 1 ]);
                }
            }).attr("src", options.src);
            return menus_jQuery.vegas;
        },
        destroy: function(what) {
            if (!what || what == "background") {
                menus_jQuery(".vegas-background, .vegas-loading").remove();
                menus_jQuery(window).unbind("*.vegas");
                menus_jQuerycurrent = menus_jQuery();
            }
            if (!what || what == "overlay") {
                menus_jQuery(".vegas-overlay").remove();
            }
            clearInterval(timer);
            return menus_jQuery.vegas;
        },
        overlay: function(settings) {
            var options = {
                src: null,
                opacity: null
            };
            menus_jQuery.extend(options, menus_jQuery.vegas.defaults.overlay, settings);
            menus_jQueryoverlay.remove();
            menus_jQueryoverlay.css({
                margin: "0",
                padding: "0",
                position: "fixed",
                left: "0px",
                top: "0px",
                width: "100%",
                height: "100%"
            });
            if (options.src) {
                menus_jQueryoverlay.css("backgroundImage", "url(" + options.src + ")");
            }
            if (options.opacity) {
                menus_jQueryoverlay.css("opacity", options.opacity);
            }
            menus_jQueryoverlay.prependTo("body");
            return menus_jQuery.vegas;
        },
        slideshow: function(settings, keepPause) {
            var options = {
                step: step,
                delay: delay,
                preload: false,
                backgrounds: backgrounds,
                walk: walk
            };
            menus_jQuery.extend(options, menus_jQuery.vegas.defaults.slideshow, settings);
            if (options.backgrounds != backgrounds) {
                if (!settings.step) {
                    options.step = 0;
                }
                if (!settings.walk) {
                    options.walk = function() {};
                }
                if (options.preload) {
                    menus_jQuery.vegas("preload", options.backgrounds);
                }
            }
            backgrounds = options.backgrounds;
            delay = options.delay;
            step = options.step;
            walk = options.walk;
            clearInterval(timer);
            if (!backgrounds.length) {
                return menus_jQuery.vegas;
            }
            var doSlideshow = function() {
                if (step < 0) {
                    step = backgrounds.length - 1;
                }
                if (step >= backgrounds.length || !backgrounds[step - 1]) {
                    step = 0;
                }
                var settings = backgrounds[step++];
                settings.walk = options.walk;
                if (typeof settings.fade == "undefined") {
                    settings.fade = options.fade;
                }
                if (settings.fade > options.delay) {
                    settings.fade = options.delay;
                }
                menus_jQuery.vegas(settings);
            };
            doSlideshow();
            if (!keepPause) {
                paused = false;
                menus_jQuery("body").trigger("vegasstart", [ menus_jQuerycurrent.get(0), step - 1 ]);
            }
            if (!paused) {
                timer = setInterval(doSlideshow, options.delay);
            }
            return menus_jQuery.vegas;
        },
        next: function() {
            var from = step;
            if (step) {
                menus_jQuery.vegas("slideshow", {
                    step: step
                }, true);
                menus_jQuery("body").trigger("vegasnext", [ menus_jQuerycurrent.get(0), step - 1, from - 1 ]);
            }
            return menus_jQuery.vegas;
        },
        previous: function() {
            var from = step;
            if (step) {
                menus_jQuery.vegas("slideshow", {
                    step: step - 2
                }, true);
                menus_jQuery("body").trigger("vegasprevious", [ menus_jQuerycurrent.get(0), step - 1, from - 1 ]);
            }
            return menus_jQuery.vegas;
        },
        jump: function(s) {
            var from = step;
            if (step) {
                menus_jQuery.vegas("slideshow", {
                    step: s
                }, true);
                menus_jQuery("body").trigger("vegasjump", [ menus_jQuerycurrent.get(0), step - 1, from - 1 ]);
            }
            return menus_jQuery.vegas;
        },
        stop: function() {
            var from = step;
            step = 0;
            paused = null;
            clearInterval(timer);
            menus_jQuery("body").trigger("vegasstop", [ menus_jQuerycurrent.get(0), from - 1 ]);
            return menus_jQuery.vegas;
        },
        pause: function() {
            paused = true;
            clearInterval(timer);
            menus_jQuery("body").trigger("vegaspause", [ menus_jQuerycurrent.get(0), step - 1 ]);
            return menus_jQuery.vegas;
        },
        get: function(what) {
            if (what === null || what == "background") {
                return menus_jQuerycurrent.get(0);
            }
            if (what == "overlay") {
                return menus_jQueryoverlay.get(0);
            }
            if (what == "step") {
                return step - 1;
            }
            if (what == "paused") {
                return paused;
            }
        },
        preload: function(backgrounds) {
            var cache = [];
            for (var i in backgrounds) {
                if (backgrounds[i].src) {
                    var cacheImage = document.createElement("img");
                    cacheImage.src = backgrounds[i].src;
                    cache.push(cacheImage);
                }
            }
            return menus_jQuery.vegas;
        }
    };
    function resize(menus_jQueryimg, settings) {
        var options = {
            align: "center",
            valign: "center"
        };
        menus_jQuery.extend(options, settings);
        if (menus_jQueryimg.height() === 0) {
            menus_jQueryimg.load(function() {
                resize(menus_jQuery(this), settings);
            });
            return;
        }
        var vp = getViewportSize(), ww = vp.width, wh = vp.height, iw = menus_jQueryimg.width(), ih = menus_jQueryimg.height(), rw = wh / ww, ri = ih / iw, newWidth, newHeight, newLeft, newTop, properties;
        
        var isIphone = (navigator.userAgent.match(/iPhone/i) != null) || (navigator.userAgent.match(/iPod/i) != null) || (navigator.userAgent.match(/Android/i) != null);
        if (isIphone) {
            ww += 100;
            wh += 100;
        }
        
        if (rw > ri) {
            newWidth = wh / ri;
            newHeight = wh;
        } else {
            newWidth = ww;
            newHeight = ww * ri;
        }
        properties = {
            width: newWidth + "px",
            height: newHeight + "px",
            top: "auto",
            bottom: "auto",
            left: "auto",
            right: "auto"
        };
        if (!isNaN(parseInt(options.valign, 10))) {
            properties.top = 0 - (newHeight - wh) / 100 * parseInt(options.valign, 10) + "px";
        } else if (options.valign == "top") {
            properties.top = 0;
        } else if (options.valign == "bottom") {
            properties.bottom = 0;
        } else {
            properties.top = (wh - newHeight) / 2;
        }
        if (!isNaN(parseInt(options.align, 10))) {
            properties.left = 0 - (newWidth - ww) / 100 * parseInt(options.align, 10) + "px";
        } else if (options.align == "left") {
            properties.left = 0;
        } else if (options.align == "right") {
            properties.right = 0;
        } else {
            properties.left = (ww - newWidth) / 2;
        }
        menus_jQueryimg.css(properties);
    }
    function loading() {
        menus_jQueryloading.prependTo("body").fadeIn();
    }
    function loaded() {
        menus_jQueryloading.fadeOut("fast", function() {
            menus_jQuery(this).remove();
        });
    }
    function getBackground() {
        if (menus_jQuery("body").css("backgroundImage")) {
            return menus_jQuery("body").css("backgroundImage").replace(/url\("?(.*?)"?\)/i, "menus_jQuery1");
        }
    }
    function getViewportSize() {
        var elmt = window, prop = "inner";
        if (!("innerWidth" in window)) {
            elmt = document.documentElement || document.body;
            prop = "client";
        }
        return {
            width: elmt[prop + "Width"],
            height: elmt[prop + "Height"]
        };
    }
    menus_jQuery.vegas = function(method) {
        if (methods[method]) {
            return methods[method].apply(this, Array.prototype.slice.call(arguments, 1));
        } else if (typeof method === "object" || !method) {
            return methods.init.apply(this, arguments);
        } else {
            menus_jQuery.error("Method " + method + " does not exist");
        }
    };
    menus_jQuery.vegas.defaults = {
        background: {},
        slideshow: {},
        overlay: {}
    };
})(menus_jQuery);