<?php
/**
 * Hook fired as a filter for the "ibm" translation api
 *
 * @param string[] input strings
 * @param Loco_Locale target locale for translations
 * @param array our own api configuration
 * @return string[] output strings
 * @throws Loco_error_Exception
 */
function ibm_translator_process_batch( array $sources, Loco_Locale $locale, array $config ){
    
    // cloud resource URL is part of the authentication, it takes form like "https://api.eu-gb.language-translator.watson.cloud.ibm.com/instances/xxxx/v3/translate?version=xxx"
    $url = $config['api'];
    
    // key authentication can be done via Basic auth
    $auth = 'Basic '.base64_encode('apikey:'.$config['key']);
    
    // map full locale to a supported language tag
    // be warned that not all regional variations are supported, e.g. pt-BR will map to just "pt"
    $tag = (string) $locale;
    $map = array (
        // Known regional locale variations:
        'fr_CA' => 'fr-CA',
        'zh_TW' => 'zh-TW',
        // Not known to be supported, but not failing
        'pt_BR' => 'pt-BR',
        // Other common mappings to supported codes
        'no' => 'nn',
        'no_NO' => 'nn',
    );
    if( array_key_exists($tag,$map) ){
        $tag = $map[$tag];
    }
    else {
        $tag = $locale->lang;
    }
    
    // request body looks like: {"text":["Hello world",...],"source":"en","target":"el"}
    // front end should have already split into a suitable sized batch ...
    $result = wp_remote_request( $url, array (
        'method' => 'POST',
        'redirection' => 0,
        'user-agent' => sprintf('Loco Translate/%s; wp-%s', loco_plugin_version(), $GLOBALS['wp_version'] ),
        'reject_unsafe_urls' => false,
        'headers' => array(
            'Content-Type' => 'application/json',
            'Authorization' => $auth,
        ),
        'body' => json_encode( array(
            'source' => 'en',
            'target' => $tag,
            'text' => $sources,
        ) ),
    ) );
    
    if( $result instanceof WP_Error ){
        foreach( $result->get_error_messages() as $message ){
            throw new Loco_error_Exception($message);
        }
    }
    
    // always decode response if server says it's JSON
    if( 'application/json' === substr($result['headers']['Content-Type'],0,16) ){
        $data = json_decode( $result['body'], true );
    }
    else {
        $data = array();
    }

    // errors look like: {"code":401, "error": "Unauthorized"}
    $status = $result['response']['code'];
    if( 200 !== $status ){
        $message = isset($data['error']) ? $data['error'] : 'Failed';
        throw new Loco_error_Exception( sprintf('IBM Translator returned status %u, %s',$status,$message) );
    }

    // response looks like: {"translations":[{"translation":"foo"},....]}
    if( ! is_array($data) || ! array_key_exists('translations',$data) || ! is_array($data['translations']) ){
        Loco_error_AdminNotices::debug( $result['body'] );
        throw new Loco_error_Exception('IBM Translator returned unexpected data');
    }
   
    // front end requires array that matches $sources
    $targets = array();
    foreach( $data['translations'] as $a ){
        $targets[] = $a['translation'];
    }

    return $targets;
}