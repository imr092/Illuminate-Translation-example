<?php
/**
 * Created by PhpStorm.
 * User: roger.s
 * Date: 2017/6/26
 * Time: 07:13
 */

use Illuminate\Filesystem\Filesystem;
use Illuminate\Translation\FileLoader;
use Illuminate\Translation\Translator;
class t
{
    private $translator;
    private function __construct()
    {
        $file = new Filesystem();
        $fileLoader = new FileLoader($file, dirname(__FILE__) . '/lang');
        $this->translator = new Translator($fileLoader, 'zh-CN');
    }

    public function getFromJson($key, array $replace = [], $locale = null)
    {
        if (strpos($key, '.') === false)
        {
            $key = 'basic.' . $key;
        }
        return $this->translator->getFromJson($key, $replace, $locale);
    }

    private static $_instance;
    public static function getInstance() {
        if (!self::$_instance instanceof self) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    public function __clone() {
        trigger_error('Cloning '.__CLASS__.' is not allowed.',E_USER_ERROR);
    }

    public function __wakeup() {
        trigger_error('Unserializing '.__CLASS__.' is not allowed.',E_USER_ERROR);
    }
}

if (! function_exists('__')) {
    function __($key = null, $replace = [], $locale = null)
    {
        return t::getInstance()->getFromJson($key, $replace, $locale);
    }
}
