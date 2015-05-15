<?php

   /**
    * Formats stuff
    *
    * @author Art <a.molcanovas@gmail.com>
    */
   abstract class Format {

      /**
       * Removes "." and ".." entries from scandir()
       *
       * @author Art <a.molcanovas@gmail.com>
       * @param array $scandir Reference to scandir() results
       */
      static function formatScandir(&$scandir) {
         $scandir = array_filter($scandir, function ($r) {
            return $r != '.' && $r != '..';
         });

         $r = [];

         foreach ($scandir as $d) {
            $r[] = $d;
         }

         $scandir = $r;
      }

      /**
       * Returns a human-friendly filesize
       *
       * @param int $bytes Filesize in bytes
       * @author Art <a.molcanovas@gmail.com>
       * @return string
       */
      static function filesize($bytes) {
         if (!is_numeric($bytes) || $bytes < 1024) {
            return $bytes . ' B';
         } elseif ($bytes < 1048576) {
            return round($bytes / 1024, 3) . ' KB';
         } elseif ($bytes < 1073741824) {
            return round($bytes / 1048576, 3) . ' MB';
         } else {
            return round($bytes / 1073741824, 3) . ' GB';
         }
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