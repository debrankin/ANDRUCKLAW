<?php

define('EMAIL_FOR_REPORTS', 'dr@debrankin.com');
define('RECAPTCHA_PRIVATE_KEY', '6LdO5u8SAAAAAEFfDMqHe6lSHDg9tvj43WA36YEx');
define('FINISH_URI', 'http://andruckilaw.com/thankyou.html');
define('FINISH_ACTION', 'redirect');
define('FINISH_MESSAGE', 'Thanks for filling out my form!');
define('UPLOAD_ALLOWED_FILE_TYPES', 'doc, docx, xls, csv, txt, rtf, html, zip, jpg, jpeg, png, gif');

require_once str_replace('\\', '/', __DIR__) . '/handler.php';

?>

<?php if (frmd_message()): ?>
<link rel="stylesheet" href="<?=dirname($form_path)?>/formoid-solid-dark.css" type="text/css" />
<span class="alert alert-success"><?=FINISH_MESSAGE;?></span>
<?php else: ?>
<!-- Start Formoid form-->
<link rel="stylesheet" href="<?=dirname($form_path)?>/formoid-solid-dark.css" type="text/css" />
<script type="text/javascript" src="<?=dirname($form_path)?>/jquery.min.js"></script>
<form class="formoid-solid-dark" style="background-color:#e0e0e0;font-size:14px;font-family:'Roboto',Arial,Helvetica,sans-serif;color:#34495E;max-width:650px;min-width:150px" method="post"><div class="title"><h2>Contact Our Office</h2></div>
	<div class="element-name<?frmd_add_class("name")?>"><label class="title"><span class="required">*</span></label><span class="nameFirst"><input placeholder="Name First" type="text" size="8" name="name[first]" required="required"/><span class="icon-place"></span></span><span class="nameLast"><input placeholder="Name Last" type="text" size="14" name="name[last]" required="required"/><span class="icon-place"></span></span></div>
	<div class="element-phone<?frmd_add_class("phone")?>"><label class="title"><span class="required">*</span></label><div class="item-cont"><input class="large" type="tel" pattern="\d{3}-\d{3}-\d{4}" maxlength="24" name="phone" required="required" placeholder="XXX-XXX-XXXX" value=""/><span class="icon-place"></span></div></div>
	<div class="element-email<?frmd_add_class("email")?>"><label class="title"><span class="required">*</span></label><div class="item-cont"><input class="large" type="email" name="email" value="" required="required" placeholder="Email"/><span class="icon-place"></span></div></div>
	<div class="element-select<?frmd_add_class("select")?>"><label class="title"><span class="required">*</span></label><div class="item-cont"><div class="large"><span><select name="select" required="required">

		<option value="Divorce	">Divorce	</option>
		<option value="Parental Rights & Responsibilities">Parental Rights & Responsibilities</option>
		<option value="Judicial Separation">Judicial Separation</option>
		<option value="Alternative Dispute Resolution">Alternative Dispute Resolution</option>
		<option value="Prenuptial Agreements">Prenuptial Agreements</option>
		<option value="Adoption">Adoption</option>
		<option value="Guardian ad Litem">Guardian ad Litem</option>
		<option value="Guardianship of a Minor">Guardianship of a Minor</option>
		<option value="Qualified Domestic Relations Order">Qualified Domestic Relations Order</option>
		<option value="Protection from Abuse">Protection from Abuse</option>
		<option value="Other">Other</option></select><i></i><span class="icon-place"></span></span></div></div></div>
	<div class="element-textarea<?frmd_add_class("textarea")?>"><label class="title"></label><div class="item-cont"><textarea class="medium" name="textarea" cols="20" rows="5" placeholder="Please provide details (optional)"></textarea><span class="icon-place"></span></div></div>
	<div class="element-checkbox<?frmd_add_class("checkbox")?>"><label class="title">Disclaimer<span class="required">*</span></label>		<div class="column column1"><label><input type="checkbox" name="checkbox[]" value="I understand that an email communication does not establish an attorney-client relationship."/ required="required"><span>I understand that an email communication does not establish an attorney-client relationship.</span></label></div><span class="clearfix"></span>
</div>
	<div class="element-recaptcha<?frmd_add_class("captcha")?>"><label class="title"></label><script type="text/javascript">var RecaptchaOptions = {theme : "clean"};</script>
<script type="text/javascript" src="http://www.google.com/recaptcha/api/challenge?k=6LdO5u8SAAAAAHhTp-fnJT0B_qphABo2hOuza1xd&theme=clean"></script>
<noscript><iframe src="http://www.google.com/recaptcha/api/noscript?k=6LdO5u8SAAAAAHhTp-fnJT0B_qphABo2hOuza1xd&hl=en" height="300" width="500" frameborder="0"></iframe></br>
<textarea name="recaptcha_challenge_field" rows="3" cols="40"></textarea><input type="hidden" name="recaptcha_response_field" value="manual_challenge"></noscript>
<script type="text/javascript">if (/#invalidcaptcha$/.test(window.location)) (document.getElementById("recaptcha_widget_div")).className += " error"</script></div>
<div class="submit"><input type="submit" value="Submit"/></div></form><script type="text/javascript" src="<?=dirname($form_path)?>/formoid-solid-dark.js"></script>

<!-- Stop Formoid form-->
<?php endif; ?>

<?php frmd_end_form(); ?>