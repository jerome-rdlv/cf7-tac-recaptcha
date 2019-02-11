# cf7-tac-recaptcha

A WordPress plugin to handle ContactForm7 reCaptcha feature with TarteAuCitron.

**Disclaimer:** I’m publishing this here because it might be useful to others,
but USE OF THIS SCRIPT IS ENTIRELY AT YOUR OWN RISK. I accept no liability from its use.  
That said, I’m using this plugin for several clients and I’m interested in any feature
or security improvement. So please contact me for this kind of requests.

## Compatibility

This plugin is now compatible with reCAPTCHA v2 and v3.

## Installation

You can drop the plugin folder in your `wp-content/plugins` or `wp-content/mu-plugins` directory.  
I recommend using `wp-content/mu-plugins` because that plugin is related to the content structure, so
it shouldn’t be managed by site admin like features (`plugins`) or appearance (`themes`).

If you use the `mu-plugins` directory, don’t forget to require it from an upper-level file
like `/wp-content/mu-plugins/index.php`:

```php
require_once __DIR__ .'/cf7-tac-recaptcha/cf7-tac-recaptcha.php';
```

## Configuration

By default, this plugin assumes that you enqueued the TarteAuCitron script with the handle `tac`
and use that handle to add its scripts. You can change that handle by using the filter
`cf7_tac_recpatcha_tac_handle`:
 
```php
add_filter('cf7_tac_recpatcha_tac_handle', function () {
    return 'tarteaucitron';
});
```

That’s all! The plugin will replace the reCaptcha script used by [ContactForm7][cf7] with the
corresponding [TarteAuCitron][tac] calls.

![](screenshot.png)

## v3 integration

For v3 integration, it is possible to keep the `[recaptcha]` field in forms and replace it with
a legal notice :

```php
if (function_exists('wpcf7_remove_form_tag')) {
    // remove original form tag which is simply deleted when reCAPTCHA v3 is enabled
    wpcf7_remove_form_tag('recaptcha');
    // add custom tag with legal notice
    wpcf7_add_form_tag('recaptcha', function () {
        return '<div class="g-recaptcha">Ce site est protégé par reCAPTCHA, et les
<a href="https://policies.google.com/privacy" target="_blank">règles de confidentialité</a> et les
<a href="https://policies.google.com/terms" target="_blank">conditions d’utilisation</a> de Google s’appliquent.
</div>';
    });
}
```

This allow to hide the v3 reCAPTCHA badge according to [Google terms](googleterms) :

```css
.grecaptcha-badge {
    display: none !important;
}
```

## Support

I’m interested in any feedback.

## Author

Jérôme Mulsant [https://rue-de-la-vieille.fr](https://rue-de-la-vieille.fr)

[tac]: https://github.com/AmauriC/tarteaucitron.js/
[cf7]: http://contactform7.com/
[googleterms]: https://developers.google.com/recaptcha/docs/faq#hiding-badge