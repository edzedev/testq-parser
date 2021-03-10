<?php


namespace App\Classes;
use HTMLPurifier_Config;
use HTMLPurifier;


class HTMLHelper
{
    /**
     * Clear parsed content before output
     *
     * @param string $content
     * @return string
     */
    public static function purify(string $content) : string
    {
        $config = HTMLPurifier_Config::createDefault();
        $config->set('HTML.Allowed', 'img[src|style|alt],b,a[href|target|rel],p,table,tbody,td,i,div[class],
        tr,th,ol,ul,li,code,span,br,h1,h2,h3,h4,h5,h6,blockquote,iframe[src|width|height],em,strong,pre');
        $config->set('HTML.SafeIframe',true);
        $config->set('URI.SafeIframeRegexp','%^https://embedd.srv.habr.com/iframe%');
        $config->set('URI.AllowedSchemes',array (
            'http' => true,
            'https' => true,
            'mailto' => true,
            'tel' => true,
            'data' => true
        ));
        $purifier = new HTMLPurifier($config);
        return $purifier->purify($content);
    }
}
