<?php
/*
 * Plugin Name: Contact Form 7 reCAPTCHA for RGPD
 */

add_action('wp_footer', function () {
    if (!wp_script_is('wpcf7-recaptcha', 'enqueued')) {
        return;
    }
    
    $plugins = get_plugins();
    $name = 'contact-form-7/wp-contact-form-7.php';
    if (!array_key_exists($name, $plugins)) {
        return;
    }
    $version = substr(md5($plugins[$name]['Version']), 0, 8);
    
    function getScript($path)
    {
        $minified = preg_replace('/\.js$/', '.min.js', $path);
        return file_exists($minified) ? $minified : $path;
    }

    function createServiceScript($bootstrap_src, $service_path)
    {
        // remove previous script versions (except current one)
        $glob = preg_replace('/-[a-z0-9]+\.js$/', '-*.js', $service_path);
        foreach (glob($glob) as $file) {
            if ($file !== $service_path) {
                unlink($file);
            }
        }

        if (file_exists($service_path)) {
            return;
        }
        
        $bootstrap_path = str_replace(WP_CONTENT_URL, WP_CONTENT_DIR, $bootstrap_src);
        if (!file_exists($bootstrap_path)) {
            return;
        }

        $bootstrap = file_get_contents($bootstrap_path);

        // replace DOMContentLoaded event because already triggered at this point
        $bootstrap = str_replace('DOMContentLoaded', 'cf7-tac-recaptcha-loaded', $bootstrap);
        $bootstrap .= 'document.dispatchEvent(new CustomEvent("cf7-tac-recaptcha-loaded"));';

        $google_recaptcha_script = wp_scripts()->registered['google-recaptcha'];
        switch ($google_recaptcha_script->ver) {
            case '2.0':
                $service = file_get_contents(getScript(__DIR__ . '/tac-service.v2.js'));
                break;
            case '3.0':
            default:
                $service = file_get_contents(getScript(__DIR__ . '/tac-service.v3.js'));
                $service = str_replace('BOOTSTRAP', $bootstrap, $service);
                break;
        }

        if ($service) {
            // save service script
            file_put_contents($service_path, $service);
        }
    }

    // dequeue google-recaptcha
    wp_dequeue_script('google-recaptcha');
//    array_push(wp_scripts()->done, 'google-recaptcha');

    $script = wp_scripts()->registered['wpcf7-recaptcha'];
    $script->deps = [];

    $service_file = sprintf('cf7-tac-recaptcha-service-%s.js', $version);
    $service_path = WP_CONTENT_DIR . '/' . $service_file;

    createServiceScript($script->src, $service_path);

    // register recaptcha service
    $tac_handle = apply_filters('cf7_tac_recpatcha_tac_handle', 'tac');
    $script->deps[] = $tac_handle;
    $script->src = WP_CONTENT_URL . '/' . $service_file;
    wp_add_inline_script(
        'wpcf7-recaptcha',
        '(tarteaucitron.job = tarteaucitron.job || []).push("recaptchacf7");',
        'after'
    );
}, 11);
