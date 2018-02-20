var widgetId = [];
var recaptchaCallback = function() {
    var recaptchas = document.getElementsByClassName("g-recaptcha");

    for(var i=0; i<recaptchas.length; i++) {
        var recaptcha = recaptchas[i];
        var sitekey = recaptcha.dataset.sitekey;

		CwidgetId = grecaptcha.render(recaptcha, {
            'sitekey' : sitekey
        });
		widgetId.push(CwidgetId);
    }
};

function lp_reset_grecaptcha(){
	for (var i = 0, len = widgetId.length; i < len; i++) {
	  grecaptcha.reset(widgetId[i]);
	}
}