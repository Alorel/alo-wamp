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
         if (!defined('PHPUNIT_RUNNING')) {
            $route = trim(strtolower(get(IO::$argv[0])));
            $file = DIR_CORE . 'routes' . DIRECTORY_SEPARATOR . $route . '.php';

            if (file_exists($file)) {
               include $file;
            } else {
               echo 'The route ' . $route . ' is invalid.' . PHP_EOL;
            }
         }
      }

      /**
       * Prints a message to exit the window
       *
       * @author Art <a.molcanovas@gmail.com>
       */
      function __destruct() {
         if (!defined('PHPUNIT_RUNNING')) {
            echo PHP_EOL . PHP_EOL . 'Press ENTER to exit' . PHP_EOL;
            IO::readline();
         }
      }
   }