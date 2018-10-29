<?php
/*
 * Plugin Name: Contact Form 7 reCAPTCHA for RGPD
 */

add_action('wp_footer', function () {
    if (!wp_script_is('google-recaptcha', 'enqueued')) {
        return;
    }
    
    $handle = apply_filters('cf7-tac-recpatcha-handle', 'tac');
    
    // remove recaptcha script
    wp_dequeue_script('google-recaptcha');

    // register tac service
    wp_add_inline_script($handle, '(tarteaucitron.job = tarteaucitron.job || []).push("recaptcha");', 'after');
}, 11);
