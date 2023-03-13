# IBM Translation API for Loco Translate

This plugin integrates the [IBM Watson™ Language Translator](https://cloud.ibm.com/catalog/services/language-translator) into [Loco Translate](https://github.com/loco/wp-loco).

External translation APIs have been available in Loco Translate since version 2.4.0. This plugin exists as an addition to the [built-in providers](https://localise.biz/wordpress/plugin/manual/providers) and serves as an example of how to add your own translation APIs via the `loco_api_providers` hook. See `plugin.php` for how this works.


### Installation

This plugin is not available from the WordPress plugin directory, so can ony be installed manually.
That means placing its files into a folder inside `wp-content/plugins`. The name of the folder is not important as long as it doesn't conflict with another plugin.

With Git, you can install the current master branch as follows from your WordPress site root:

```sh
git clone https://github.com/loco/wp-ibm-translator.git wp-content/ibm-translation-api
```

Alternatively download [master.zip](https://github.com/loco/wp-ibm-translator/archive/master.zip) and install the files via WordPress admin or by uploading them to your server.
See the WordPress documentation on [installing plugins manually](https://wordpress.org/support/article/managing-plugins/#manual-upload-via-wordpress-admin).



### Configuration

To use the plugin with your IBM Cloud account, define the following constants in `wp-config.php` as follows:

```php
define('IBM_API_KEY','YOUR API KEY');
define('IBM_API_URL','https://... YOUR ENDPOINT');
```

Your resource URL will look something like this:  
`https://api.xx-xx.language-translator.watson.cloud.ibm.com/instances/SOME-LONG-ID/v3/translate?version=2018-05-01`

Please read the IBM Cloud [getting started guide](https://cloud.ibm.com/docs/language-translator?topic=language-translator-gettingstarted) to learn how to generate your API key and get your resource URL.




### FAQs

#### Why is this a separate plugin from Loco Translate?

This plugin is really just a proof of concept. Loco Translate already includes [four popular API providers](https://localise.biz/wordpress/plugin/manual/providers), but there are many more.
It makes sense that translation providers can be added as separate modules according to people's specific needs. If a particular provider becomes very popular we'll consider bundling it into the main plugin.

On a technical point: we found that the IBM Translation API couldn't be implemented purely in JavaScript (no CORS. no JSONP). 
This sets it apart from the four bundled providers which do not require any back end processing, so we figured it was a good candidate for testing the pluggable API concept.

#### Why are there no release versions?

The current state of this plugin is effectively a beta release of an experimental plugin.
A release cycle will begin once we're happy the intial version is stable and appears to be in active use.

#### Why can't I configure it from WordPress admin?

This is on our todo list. The quick/easy way to get this plugin working was to use a code-based configuration.


### Support

If you have any questions, please ask on the WordPress support forum for Loco Translate:
[http://wordpress.org/support/plugin/loco-translate](http://wordpress.org/support/plugin/loco-translate)

If you've found a demonstrable bug in this plugin, then please open a [Github issue](https://github.com/loco/wp-ibm-translator/issues).
