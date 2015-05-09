<?php

   /**
    * Formats stuff
    *
    * @author Art <a.molcanovas@gmail.com>
    */
   abstract class Format {

      /**
       * Turns an array into an ini format
       *
       * @author Art <a.molcanovas@gmail.com>
       * @param array $a The array
       * @return string Generated contents
       */
      static function array_to_ini(array $a) {
         $r = '';

         foreach ($a as $k => $v) {
            $r .= "[$k]" . PHP_EOL;

            foreach ($v as $key => $value) {
               $r .= "$key=$value" . PHP_EOL;
            }
         }

         return $r;
      }

      /**
       * Turns an ini to an array.
       *
       * @param string $var     Ini contents or filepath
       * @param bool   $is_file TRUE if $var is a filepath, FALSE if ini contents
       * @return array
       */
      static function ini_to_array($var, $is_file = true) {
         return $is_file ? parse_ini_file($var, true) : parse_ini_string($var, true);
      }
   }