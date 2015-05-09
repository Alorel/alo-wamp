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