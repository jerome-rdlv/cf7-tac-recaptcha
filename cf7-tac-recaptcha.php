<?php
/*
 * Plugin Name: Contact Form 7 reCAPTCHA for RGPD
 */

add_action('wp_footer', function () {
    
    if (!wp_script_is('google-recaptcha', 'enqueued')) {
        return;
    }
    
    $script = wp_scripts()->query('google-recaptcha');

    switch ($script->ver) {
        case '2.0':
            $service = file_get_contents(__DIR__ .'/tac-service.v2.js');
            break;
        case '3.0':
            $service = file_get_contents(__DIR__ .'/tac-service.v3.js');
            $site_key = preg_replace('/^.*(\?|&)render=([^&]+)$/', '\2', $script->src);
            $service = preg_replace('/{site-key}/', $site_key, $service);
            break;
    }
    
    if ($service) {
        // remove recaptcha script
        wp_dequeue_script('google-recaptcha');
        
        // register recaptcha service
        $tac_handle = apply_filters('cf7_tac_recpatcha_tac_handle', 'tac');
        wp_add_inline_script($tac_handle, $service, 'after');
        wp_add_inline_script($tac_handle, '(tarteaucitron.job = tarteaucitron.job || []).push("recaptchacf7");', 'after');
    }
    
}, 11);
