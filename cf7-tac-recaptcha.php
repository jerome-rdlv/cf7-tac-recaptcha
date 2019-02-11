<?php
/*
 * Plugin Name: Contact Form 7 reCAPTCHA for RGPD
 */

add_action('wp_footer', function () {
    
    if (!wp_script_is('google-recaptcha', 'enqueued')) {
        return;
    }
    
    $script = wp_scripts()->query('google-recaptcha');
    
    $bootstrap = '// reCAPTCHA bootstrap';
    if (function_exists('wpcf7_recaptcha_onload_script')) {
        array_push(wp_scripts()->done, 'google-recaptcha');
        ob_start();
        wpcf7_recaptcha_onload_script();
        $bootstrap = preg_replace('/<\/?script[^>]*>/', '', ob_get_clean());
        array_pop(wp_scripts()->done);
    }
    
    switch ($script->ver) {
        case '2.0':
            $service = file_get_contents(__DIR__ .'/tac-service.v2.js');
            break;
        case '3.0':
            $service = file_get_contents(__DIR__ .'/tac-service.v3.js');
            $site_key = preg_replace('/^.*(\?|&)render=([^&]+)$/', '\2', $script->src);
            $service = str_replace(
                ['{site-key}', '{bootstrap}'],
                [$site_key, $bootstrap],
                $service
            );
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
