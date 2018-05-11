/* 
	Flexi ContactForms error messages

	Modify the messages bellow if you want to customize the error messages thrown by your contact forms. 

*/
var xtdContactFormsMessages = { 
	"email" 	: "Email value is not correct.", // The error will appear when Email field is required but is not filled out	

	"website" 	: "Website value is not correct.", // The error will appear when Website field is required but is not filled out

	"phone"	    : "Phone value is not correct.", // The error will appear when Phone field is required but is not filled out	

	"code"		: "Postal code must be just numbers.", // The error will appear when ZIP/Postal Code field contains anything but numbers

	"numberbox" : "Number Box must be just numbers.", // The error will appear when Number Box field contains anything but numbers

	"captcha"   : "Captcha value is not correct.", // The error will appear when Captcha field is required but is not filled out	

	"phperror"  : "There was a problem sending your message. Please try again.", // The error will appear when PHP script fails

	"required"	: "This value is required" // The error will appear when a value is not typed in input field
};





/**
	Flexi ContactForms initialization	
*/

(function($) {
   
	if(!window.xtdContactFormsMessages){
        xtdContactFormsMessages = xtdDefaultContactFormsMessages;
    }

    $(document).ready(function(){

// ContactForm start

$('.ContactForms1').xtdContactForm({ 
 	"emailSent" : "firstOption", 
 	"relPath" : "", 
 	"emailSentMessage" : "Thank%20you!"
 });

$('.ContactForms2').xtdContactForm({ 
 	"emailSent" : "firstOption", 
 	"relPath" : "", 
 	"emailSentMessage" : "Your%20message%20was%20sent%20successfully!"
 });

$('.ContactForms3').xtdContactForm({"emailSent":"firstOption","relPath":"","emailSentMessage":"Thank%20you!"});
// ContactForm end 

    });


}(menus_jQuery));