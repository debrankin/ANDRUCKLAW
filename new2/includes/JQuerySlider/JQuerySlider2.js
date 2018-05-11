var JQuerySlider2_json = 
	{
          "innernumbers.mouseOutEffect": "fadeIn",
          "innerplaypause.mouseOutEffectDuration": "1000",
          "speed": "1000",
          "innerbullets.hideOnMouseOut": false,
          "pause": "1000",
          "innerbutton.next.opacity": 1,
          "innerbutton.back.backgroundType": "normal",
          "innerbutton.next.mouseOutEffectDuration": "300",
          "innernavbaritem.spacing": "10px",
          "innerplaypause.left": "15px",
          "innerplaypause.opacity": 1,
          "innerplaypause.pause.backgroundType": "normal",
          "innerbutton.hover.backgroundType": "normal",
          "innerbutton.back.left": "0px",
          "innerbutton.back.hideOnMouseOut": true,
          "innerplaypause.play.backgroundType": "normal",
          "innerbutton.back.valign": "middle",
          "sliderEffect": "slide",
          "innerplaypause.mouseOutEffectEasing": "linear",
          "auto": true,
          "innerbullets.mouseOutEffectDuration": "1000",
          "innernavbar.mouseOutEffectDuration": "500",
          "innerbullets.left": "0px",
          "innerbutton.back.halign": "left",
          "gifPath": "includes/JQuerySlider/x.gif",
          "innerbutton.next.left": "0px",
          "hideOnMouseOut": true,
          "innernavbar.left": "0px",
          "innerbutton.next.backgroundType": "normal",
          "innernumbers.left": "0px",
          "innerslider.top": "0px",
          "resumeDuration": "3000",
          "innerbutton.next.top": "1px",
          "innernavbaritem.active.backgroundType": "",
          "innerbulletsitem.active.backgroundType": "normal",
          "continuous": true,
          "innerplaypause.play.hover.backgroundType": "normal",
          "innernumbers.halign": "right",
          "innerplaypause.pause.hover.backgroundType": "normal",
          "innerbutton.next.mouseOutEffect": "slideFromRight",
          "innerbutton.back.opacity": 1,
          "innernavbar.mouseOutEffect": "slideFromBottom",
          "innerplaypause.valign": "top",
          "innerbutton.next.hideOnMouseOut": true,
          "innernumbers.mouseOutEffectEasing": "linear",
          "innernumbersitem.orientation": "horizontal",
          "loop": true,
          "innernavbar.valign": "bottom",
          "innerbulletsitem.spacing": "0px",
          "innernumbersitem.spacing": "0px",
          "innernumbers.valign": "bottom",
          "innerbullets.halign": "right",
          "innernavbar.hideOnMouseOut": false,
          "innernumbers.top": "0px",
          "innerbullets.top": "30px",
          "backgroundType": "normal",
          "innernumbers.spacing": "0px",
          "innerbutton.back.mouseOutEffectDuration": "300",
          "innernumbers.mouseOutEffectDuration": "1000",
          "innerbutton.back.top": "0px",
          "innernavbaritem.hover.backgroundType": "",
          "innerplaypause.top": "5px",
          "innerbutton.back.mouseOutEffect": "slideFromLeft",
          "innerbulletsitem.orientation": "horizontal",
          "innerbutton.back.mouseOutEffectEasing": "linear",
          "innerplaypause.halign": "right",
          "innerplaypause.mouseOutEffect": "fadeIn",
          "innerbullets.mouseOutEffect": "fadeIn",
          "innerbullets.mouseOutEffectEasing": "linear",
          "innernumbers.hideOnMouseOut": false,
          "innerbutton.next.mouseOutEffectEasing": "linear",
          "innerslider.left": "0px",
          "stopAtInteraction": true,
          "vertical": false,
          "height": "-2px",
          "innernavbar.top": "0px",
          "innerbullets.valign": "bottom",
          "innernavbar.halign": "left",
          "innernavbaritem.orientation": "horizontal",
          "innerplaypause.hideOnMouseOut": false,
          "width": "-2px",
          "innerbutton.next.valign": "middle",
          "innerbutton.next.halign": "right",
          "fadeDuration": "1000",
          "ease": "easeOut",
          "innernavbar.mouseOutEffectEasing": "linear"
};
	
var JQuerySlider2_slider = null;	

xtd_jQuery(document).ready(function(){
	var $ = xtd_jQuery;
	var jQuery = xtd_jQuery;
	
	$("#JQuerySlider2Container").hide();
	
	// fix bug on webkit//
	if (jQuery.browser.webkit && document.readyState != "complete") {
		setTimeout( createJQuerySlider, 100 );
	} else {
		createJQuerySlider()
	}
		
	function createJQuerySlider() {

		if (document.readyState && document.readyState != "complete") {
			setTimeout( createJQuerySlider, 100 );
			return;
		}

		//show element first as height/width of auto elements is 0 if container is hidden//
		$("#JQuerySlider2Container").show();
		
		// create the slider
		JQuerySlider2_slider = $("#JQuerySlider2").jQuerySlider();
	}
});