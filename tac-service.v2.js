tarteaucitron.services.recaptchacf7 = {
    "key": "recaptchacf7",
    "type": "api",
    "name": "reCAPTCHA v2",
    "uri": "http://www.google.com/policies/privacy/",
    "needConsent": true,
    "cookies": ["nid"],
    "js": function () {
        "use strict";
        tarteaucitron.fallback(["g-recaptcha"], "");
        tarteaucitron.addScript("https://www.google.com/recaptcha/api.js?onload=recaptchaCallback&render=explicit&ver=2.0");
    },
    "fallback": function () {
        "use strict";
        var id = "recaptchacf7";
        tarteaucitron.fallback(["g-recaptcha"], tarteaucitron.engage(id));
    }
};