(function (tarteaucitron) {
    if (!tarteaucitron) {
        return;
    }
    tarteaucitron.services.recaptchacf7 = {
        "key": "recaptchacf7",
        "type": "api",
        "name": "reCAPTCHA v3",
        "uri": "https://policies.google.com/privacy",
        "needConsent": true,
        "cookies": ["nid"],
        "js": function () {
            "use strict";
            tarteaucitron.fallback(["g-recaptcha"], function (node) {
                if (node._inner) {
                    node.innerHTML = node._inner;
                }
            }, true);
            var scriptUrl = "https://www.google.com/recaptcha/api.js?render=" + wpcf7_recaptcha.sitekey;
            tarteaucitron.addScript(scriptUrl, '', function () {
                BOOTSTRAP;
            });
        },
        "fallback": function () {
            "use strict";
            var id = "recaptchacf7";
            tarteaucitron.fallback(["g-recaptcha"], function (node) {
                node._inner = node.innerHTML;
                return tarteaucitron.engage(id);
            });
        }
    };
})(window.tarteaucitron);
