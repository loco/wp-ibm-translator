# IBM Translation API for Loco Translate

This plugin integrates the [IBM Watson™ Language Translator](https://cloud.ibm.com/catalog/services/language-translator) into [Loco Translate](https://github.com/loco/wp-loco).

External translation APIs were made available in Loco Translate from version 2.4.0. This plugin exists as an addition to the [built-in providers](https://localise.biz/wordpress/plugin/manual/providers) and serves as an example of how to add your own translation APIs via the `loco_api_providers` hook. See `plugin.php` for how this works.

This API has not been added to Loco Translate's built-in providers because it does not support CORS. As such it only works via the hookable architecture, so it is separate for the time being.

To use the plugin with your IBM Cloud account, define the following constants in `wp-config.php`

```php
define('IBM_API_KEY','YOUR API KEY');
define('IBM_API_URL','YOUR ENDPOINT');
```

Your resource URL will look something like this:
`https://api.xx-xx.language-translator.watson.cloud.ibm.com/instances/SOME-LONG-ID/v3/translate?version=2018-05-01`

Please read the IBM Cloud documentation to learn how to generate your API key and get your resource URL.


If you have any questions, please ask on the WordPress support forum:
[http://wordpress.org/support/plugin/loco-translate](http://wordpress.org/support/plugin/loco-translate)
