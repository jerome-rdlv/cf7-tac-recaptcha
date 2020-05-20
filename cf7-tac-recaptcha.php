<?php
/*
 * Plugin Name: Contact Form 7 reCAPTCHA for RGPD
 */

add_action('wp_footer', function () {

    if (!wp_script_is('google-recaptcha', 'enqueued')) {
        return;
    }

    $script = wp_scripts()->query('google-recaptcha');

    function getScript($path)
    {
        $minified = preg_replace('/\.js$/', '.min.js', $path);
        return file_exists($minified) ? $minified : $path;
    }

    $bootstrap = '// reCAPTCHA bootstrap';
    if (function_exists('wpcf7_recaptcha_onload_script')) {
        array_push(wp_scripts()->done, 'google-recaptcha');
        ob_start();
        wpcf7_recaptcha_onload_script();
        $bootstrap = preg_replace('/<\/?script[^>]*>/', '', ob_get_clean());
        array_pop(wp_scripts()->done);

        // replace DOMContentLoaded event because already triggered at this point
        $bootstrap = str_replace('DOMContentLoaded', 'cf7-tac-recaptcha-loaded', $bootstrap);
        $bootstrap .= 'document.dispatchEvent(new CustomEvent("cf7-tac-recaptcha-loaded"));';

        // todo forget about minification and serve the bundle as file
        // todo store outside of plugin in a cache directory
        $path = __DIR__ . '/bootstrap.js';
        $minified = __DIR__ . '/bootstrap.min.js';
        $write = true;
        if (file_exists($path)) {
            $previous = file_get_contents($path);
            if ($previous !== $bootstrap) {
                $write = true;
                if (file_exists($minified)) {
                    unlink($minified);
                }
            }
        }
        if ($write) {
            file_put_contents($path, $bootstrap);
        }

        if (file_exists($minified)) {
            $bootstrap = file_get_contents($minified);
        }
    }

    switch ($script->ver) {
        case '2.0':
            $service = file_get_contents(getScript(__DIR__ . '/tac-service.v2.js'));
            break;
        case '3.0':
            $service = file_get_contents(getScript(__DIR__ . '/tac-service.v3.js'));
            $site_key = preg_replace('/^.*(\?|&)render=([^&]+)$/', '\2', $script->src);
            $service = str_replace(
                ['SITE_KEY', 'BOOTSTRAP'],
                [$site_key, $bootstrap],
                $service
            );
            break;
    }

    if ($service) {
        // remove recaptcha script
        wp_dequeue_script('google-recaptcha');

        // register recaptcha service
        // todo serve as file instead of inline script
        $tac_handle = apply_filters('cf7_tac_recpatcha_tac_handle', 'tac');
        wp_add_inline_script($tac_handle, $service, 'after');
        wp_add_inline_script($tac_handle, '(tarteaucitron.job = tarteaucitron.job || []).push("recaptchacf7");',
            'after');
    }

}, 11);
