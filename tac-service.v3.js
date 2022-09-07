window.tarteaucitron && (function (tac) {
    tac.services.recaptcha_cf7 = {
        "key": "recaptcha_cf7",
        "type": "api",
        "name": "reCAPTCHA v3",
        "uri": "https://policies.google.com/privacy",
        "needConsent": true,
        "cookies": ["nid"],
        "js": function () {
            "use strict";
            tac.fallback(["g-recaptcha"], function (node) {
                node._inner && (node.innerHTML = node._inner);
            }, true);
            var scriptUrl = "https://www.google.com/recaptcha/api.js?render=" + wpcf7_recaptcha.sitekey;
            tac.addScript(scriptUrl, '', function () {
                BOOTSTRAP;
            });
        },
        "fallback": function () {
            "use strict";
            var id = "recaptcha_cf7";
            tac.fallback(["g-recaptcha"], function (node) {
                node._inner || (node._inner = node.innerHTML);
                var engage = node.getAttribute('data-engage');
                if (engage) {
                    tac.lang['engage-' + id] = engage;
                }
                return tac.engage(id);
            });
        }
    };
})(window.tarteaucitron);