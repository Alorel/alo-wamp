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
    * Redis directory
    *
    * @var string
    */
   define('DIR_REDIS', DIR_BIN . 'redis' . DIRECTORY_SEPARATOR);

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

   /**
    * WWW directory
    *
    * @var string
    */
   define('DIR_WWW', DIR_INDEX . 'www' . DIRECTORY_SEPARATOR);

   /**
    * Log directory
    *
    * @var string
    */
   define('DIR_LOGS', DIR_INDEX . 'logs' . DIRECTORY_SEPARATOR);

   /**
    * Path to the service checker executable
    *
    * @var string
    */
   define('SERVICEEXISTS', '"' . DIR_CORE . 'bin' . DIRECTORY_SEPARATOR . 'serviceexists.bat"');

   /**
    * Homepage URL
    *
    * @var string
    */
   define('HOMEPAGE', 'https://github.com/Alorel/AloWAMP');

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

   /**
    * Output wapper
    *
    * @author Art <a.molcanovas@gmail.com>
    * @param string $str String to echo
    */
   function _echo($str) {
      echo '[' . date('Y-m-d H:i:s') . '] ' . $str . PHP_EOL;
   }

   require_once DIR_CORE . 'class' . DIRECTORY_SEPARATOR . 'handler.php';

   spl_autoload_register('Handler::autoloader');
   IO::echo_lines();
   new Settings();

   $r = new Router();
   $r->route();

