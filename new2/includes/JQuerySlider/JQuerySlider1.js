var JQuerySlider1_json = 
	{
          "innerbutton.back.mouseOutEffectDuration": "200",
          "speed": "500",
          "innerplaypause.valign": "top",
          "innernavbar.hideOnMouseOut": false,
          "innernumbers.spacing": "0px",
          "innerbullets.top": "50px",
          "innerslider.top": "0px",
          "hideOnMouseOut": true,
          "innernumbers.mouseOutEffect": "fadeIn",
          "innerbutton.back.mouseOutEffectEasing": "swing",
          "continuous": true,
          "resumeDuration": "3000",
          "innerbulletsitem.spacing": "0px",
          "innerbullets.halign": "center",
          "innernumbers.mouseOutEffectEasing": "linear",
          "innernavbar.mouseOutEffect": "fadeIn",
          "innernumbers.valign": "bottom",
          "innernavbar.valign": "bottom",
          "auto": true,
          "innernumbers.hideOnMouseOut": false,
          "innernumbers.mouseOutEffectDuration": "1000",
          "innerplaypause.halign": "left",
          "innerbutton.back.hideOnMouseOut": "",
          "innerbulletsitem.orientation": "horizontal",
          "innerbutton.next.mouseOutEffectEasing": "swing",
          "innerplaypause.top": "0px",
          "backgroundType": "normal",
          "innernavbar.itemsalign": "center",
          "innerbutton.next.mouseOutEffectDuration": "200",
          "innerbutton.back.left": "2px",
          "innerbutton.next.halign": "right",
          "loop": true,
          "innerbullets.mouseOutEffectEasing": "linear",
          "innerplaypause.mouseOutEffect": "fadeIn",
          "innernavbar.halign": "left",
          "innernavbar.top": "0px",
          "innerbullets.mouseOutEffect": "slideFromBottom",
          "stopAtInteraction": false,
          "innerplaypause.hideOnMouseOut": false,
          "innernumbers.left": "20px",
          "innernavbaritem.orientation": "horizontal",
          "innerplaypause.mouseOutEffectDuration": "1000",
          "innerplaypause.mouseOutEffectEasing": "linear",
          "innerbutton.next.left": "0px",
          "innerbullets.valign": "bottom",
          "fadeDuration": "500",
          "innerplaypause.left": "0px",
          "innerbullets.mouseOutEffectDuration": "500",
          "innerbutton.next.valign": "middle",
          "width": "698px",
          "ease": "easeOut",
          "innernavbar.mouseOutEffectDuration": "1000",
          "height": "298px",
          "innernumbersitem.orientation": "horizontal",
          "innerbutton.back.top": "-40px",
          "innernavbar.mouseOutEffectEasing": "linear",
          "innerbutton.back.mouseOutEffect": "fadeIn",
          "innerbullets.hideOnMouseOut": false,
          "innerbutton.next.mouseOutEffect": "fadeIn",
          "innernumbers.top": "25px",
          "innerslider.left": "0px",
          "innerbullets.left": "-10px",
          "vertical": false,
          "innerbutton.back.halign": "left",
          "gifPath": "includes/JQuerySlider/x.gif",
          "innernumbers.halign": "right",
          "innerbutton.back.valign": "middle",
          "innerbutton.next.hideOnMouseOut": "",
          "innernavbar.left": "0px",
          "innernavbaritem.spacing": "0px",
          "innerbutton.next.top": "-40px",
          "pause": "4000"
};
	
var JQuerySlider1_slider = null;	

xtd_jQuery(document).ready(function(){
	var $ = xtd_jQuery;
	var jQuery = xtd_jQuery;
	
	$("#JQuerySlider1Container").hide();
	
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
		$("#JQuerySlider1Container").show();
		
		// create the slider
		JQuerySlider1_slider = $("#JQuerySlider1").jQuerySlider();
	}
});