# cf7-tac-recaptcha

A WordPress plugin to handle ContactForm7 reCaptcha feature with TarteAuCitron.

**Disclaimer:** I’m publishing this here because it might be useful to others,
but USE OF THIS SCRIPT IS ENTIRELY AT YOUR OWN RISK. I accept no liability from its use.  
That said, I’m using this plugin for several clients and I’m interested in any feature
or security improvement. So please contact me for this kind of requests.

## Installation

You can drop the plugin folder in your `wp-content/plugins` or `wp-content/mu-plugins` directory.  
I recommend using `wp-content/mu-plugins` because that plugin is related to the content structure, so
it shouldn’t be managed by site admin like features (`plugins`) or appearance (`themes`).

If you use the `mu-plugins` directory, don’t forget to require it from an upper-level file
like `/wp-content/mu-plugins/index.php`:

```php
require_once __DIR__ .'/cf7-tac-recaptcha/cf7-tac-recaptcha.php';
```

That’s all! The plugin will replace the recaptcha script used by ContactForm7 with the
corresponding TarteAuCitron calls.

![](screenshot.png)

## Support

I’m interested in any feedback.

## Author

Jérôme Mulsant [https://rue-de-la-vieille.fr](https://rue-de-la-vieille.fr)