<?php

   /**
    * Handles stuff
    *
    * @author Art <a.molcanovas@gmail.com>
    */
   abstract class Handler {

      /**
       * Class/interface/trait autoloader
       *
       * @author Art <a.molcanovas@gmail.com>
       *
       * @param string $name Class name
       */
      static function autoloader($name) {
         $name      = ltrim(strtolower(str_replace('\\', DIRECTORY_SEPARATOR, $name)), '/') . '.php';
         $locations = [
            DIR_CORE . 'class',
            DIR_CORE . 'interface',
            DIR_CORE . 'trait'
         ];

         foreach($locations as $l) {
            if(file_exists($l . DIRECTORY_SEPARATOR . $name)) {
               include_once $l . DIRECTORY_SEPARATOR . $name;
               break;
            }
         }
      }

   }