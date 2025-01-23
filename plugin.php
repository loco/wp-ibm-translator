<?php
/*
Plugin Name: IBM Translation API for Loco Translate
Plugin URI: https://github.com/loco/wp-ibm-translator
Description: Integrates the IBM Watson™ Language Translator service into Loco Translate
Author: Tim Whitlock
Version: 1.1.0
Author URI: https://localise.biz/wordpress/plugin
*/
if( is_admin() ){

    // Append our api via the `loco_api_providers` filter hook.
    // This should be available all the time Loco Translate is running.
    function ibm_translator_filter_apis( array $apis ){
        $apis[] = [
            'id' => 'ibm',
            'name' => 'IBM Watson™',
            'key' => loco_constant('IBM_API_KEY'),
            'api' => loco_constant('IBM_API_URL'),
            'url' => 'https://cloud.ibm.com/catalog/services/language-translator',
        ];
        return $apis;
    }
    add_filter('loco_api_providers','ibm_translator_filter_apis',10,1);

    // Hook our translate function with 'loco_api_translate_{$id}'
    // We only need to do this when the Loco Translate Ajax hook is running.
    function ibm_translator_ajax_init(){
        require __DIR__.'/translator.php';
        add_filter('loco_api_translate_ibm','ibm_translator_process_batch',0,4);
    }
    add_action('loco_api_ajax','ibm_translator_ajax_init',0,0);

}
