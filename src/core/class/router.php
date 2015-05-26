<?php

   /**
    * Core routing and configuration class
    *
    * @author Art <a.molcanovas@gmail.com>
    */
   class Router {

      /**
       * Attempts to route a request
       *
       * @author Art <a.molcanovas@gmail.com>
       */
      function route() {
         if(!defined('PHPUNIT_RUNNING')) {
            $route = trim(strtolower(get(IO::$argv[0])));
            $file  = DIR_CORE . 'routes' . DIRECTORY_SEPARATOR . $route . '.php';

            if(file_exists($file)) {
               include $file;
            } else {
               _echo('The route ' . $route . ' is invalid.');
            }
         }
      }

      /**
       * Echoes some empty lines before the "press any key to exit" bit
       *
       * @author Art <a.molcanovas@gmail.com>
       */
      function __destruct() {
         echo PHP_EOL . PHP_EOL;
      }
   }