tarteaucitron.services.recaptchacf7 = {
    "key": "recaptchacf7",
    "type": "api",
    "name": "reCAPTCHA v3",
    "uri": "https://policies.google.com/privacy",
    "needConsent": true,
    "cookies": ["nid"],
    "js": function () {
        "use strict";
        tarteaucitron.fallback(["g-recaptcha"], "");
        tarteaucitron.addScript("https://www.google.com/recaptcha/api.js?render={site-key}");
    },
    "fallback": function () {
        "use strict";
        var id = "recaptchacf7";
        tarteaucitron.fallback(["g-recaptcha"], tarteaucitron.engage(id));
    }
};