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

   require_once DIR_CORE . 'class' . DIRECTORY_SEPARATOR . 'handler.php';

   spl_autoload_register('Handler::autoloader');

   IO::echo_lines();

   $r = new Router();
   $r->route();

