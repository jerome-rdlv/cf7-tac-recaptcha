<?php
/*
 * Plugin Name: Contact Form 7 reCAPTCHA for RGPD
 */

add_action('wp_footer', function () {
    if (!wp_script_is('google-recaptcha', 'enqueued')) {
        return;
    }
    
    // remove recaptcha script
    wp_dequeue_script('google-recaptcha');

    // add customized tac service
    $tacReCaptchaService = 'tarteaucitron.services.recaptchacf7 = {
    "key": "recaptchacf7",
    "type": "api",
    "name": "reCAPTCHA",
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
};';
    wp_add_inline_script('tac', $tacReCaptchaService, 'after');

    // register tac service
    wp_add_inline_script('tac', '(tarteaucitron.job = tarteaucitron.job || []).push("recaptchacf7");', 'after');
}, 11);
