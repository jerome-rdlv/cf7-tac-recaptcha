window.tarteaucitron && (function (tac) {
    tac.services.recaptcha_cf7 = {
        "key": "recaptcha_cf7",
        "type": "api",
        "name": "reCAPTCHA v2",
        "uri": "http://www.google.com/policies/privacy/",
        "needConsent": true,
        "cookies": ["nid"],
        "js": function () {
            "use strict";
            tac.fallback(["g-recaptcha"], "");
            tac.addScript("https://www.google.com/recaptcha/api.js");
        },
        "fallback": function () {
            "use strict";
            var id = "recaptcha_cf7";
            tac.fallback(["g-recaptcha"], tac.engage(id));
        }
    };
})(window.tarteaucitron);