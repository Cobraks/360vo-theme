<?php
// classes/class-e360vo-asset-minifier.php
if (! defined('ABSPATH')) {
    exit;
}

class E360VO_AssetMinifier
{
    protected static $assets = [];

    public static function init()
    {
        add_action('wp_enqueue_scripts', [__CLASS__, 'maybe_minify_all'], 0);
        add_action('admin_enqueue_scripts', [__CLASS__, 'maybe_minify_all'], 0);
    }

    public static function register($handle, $orig, $min, $type = 'css')
    {
        if (in_array($type, ['css', 'js'], true) && file_exists($orig)) {
            self::$assets[$handle] = compact('orig', 'min', 'type');
            self::maybe_minify($orig, $min, $type);
        }
    }

    public static function maybe_minify_all()
    {
        foreach (self::$assets as $info) {
            self::maybe_minify($info['orig'], $info['min'], $info['type']);
        }
    }

    protected static function maybe_minify($orig, $min, $type)
    {
        $mtO = filemtime($orig);
        $mtM = file_exists($min) ? filemtime($min) : 0;
        if ($mtO <= $mtM) {
            return;
        }
        $code = file_get_contents($orig);
        if ($type === 'css') {
            $code = preg_replace('!/\*.*?\*/!s', '', $code);
            $code = preg_replace('/\s+/', ' ', $code);
            $code = str_replace([' {', '{ ', ' }', '} ', ' ;', '; '], ['{', '{', '}', '}', ';', ';'], $code);
            $code = trim($code);
        } else {
            $code = preg_replace('!/\*.*?\*/!s', '', $code);
            $code = preg_replace('/\/\/[^\n]*/', '', $code);
            $code = preg_replace('/\s+/', ' ', $code);
            $code = trim($code);
        }
        file_put_contents($min, $code);
        @chmod($min, 0644);
    }
}
