<?php

   $prev_dir = explode(DIRECTORY_SEPARATOR, __DIR__);
   array_pop($prev_dir);

   /**
    * Core directory
    *
    * @var string
    */
   define('DIR_CORE', __DIR__ . DIRECTORY_SEPARATOR);

   /**
    * Index directory
    *
    * @var string
    */
   define('DIR_INDEX', implode(DIRECTORY_SEPARATOR, $prev_dir) . DIRECTORY_SEPARATOR);

   /**
    * PHP engine directory
    *
    * @var string
    */
   define('DIR_PHP_ENGINE', DIR_CORE . 'bin' . DIRECTORY_SEPARATOR . 'php_engine' . DIRECTORY_SEPARATOR);

   /**
    * Path to PHP executable
    *
    * @var string
    */
   define('PHP_EXECUTABLE', DIR_PHP_ENGINE . 'php.exe');

   /**
    * Binaries directory
    *
    * @var string
    */
   define('DIR_BIN', DIR_INDEX . 'bin' . DIRECTORY_SEPARATOR);

   /**
    * Memcache directory
    *
    * @var string
    */
   define('DIR_MEMCACHE', DIR_BIN . 'memcache' . DIRECTORY_SEPARATOR);

   /**
    * Apache directory
    *
    * @var string
    */
   define('DIR_APACHE', DIR_BIN . 'apache' . DIRECTORY_SEPARATOR);

   /**
    * PHP directory
    *
    * @var string
    */
   define('DIR_PHP', DIR_BIN . 'php' . DIRECTORY_SEPARATOR);

   /**
    * MySQL directory
    *
    * @var string
    */
   define('DIR_MYSQL', DIR_BIN . 'mysql' . DIRECTORY_SEPARATOR);

   /**
    * Temporary directory
    *
    * @var string
    */
   define('DIR_TMP', DIR_INDEX . 'tmp' . DIRECTORY_SEPARATOR);

   define('DIR_WWW', DIR_INDEX . 'www' . DIRECTORY_SEPARATOR);

   /**
    * Shortcut for isset($var) ? $var : null
    *
    * @author Art <a.molcanovas@gmail.com>
    * @param mixed $var Reference to the variable
    * @return mixed|null The variable or NULL if it's not defined
    */
   function get(&$var) {
      return isset($var) ? $var : null;
   }

   function _($str) {
      echo $str . PHP_EOL;
   }

   require_once DIR_CORE . 'class' . DIRECTORY_SEPARATOR . 'handler.php';

   spl_autoload_register('Handler::autoloader');
   IO::echo_lines();
   new Settings();

   $r = new Router();
   $r->route();

