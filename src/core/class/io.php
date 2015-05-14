<?php

   /**
    * Handles input & output
    *
    * @author Art <a.molcanovas@gmail.com>
    */
   abstract class IO {

      /**
       * Arguments passed on to PHP
       *
       * @var array
       */
      public static $argv;

      /**
       * Clears previous output
       *
       * @author Art <a.molcanovas@gmail.com>
       * @param int $lines Amount of empty lines to output
       */
      static function echo_lines($lines = 100) {
         $l = "";
         $lines = (int)$lines;

         for ($i = 0; $i < $lines; $i++) {
            $l .= PHP_EOL;
         }

         echo $l;
      }

      /**
       * Opens a file
       *
       * @author Art <a.molcanovas@gmail.com>
       * @param string $path File path
       */
      static function open_file($path) {
         shell_exec('start ' . $path);
      }

      /**
       * Reads a line of user input
       *
       * @author Art <a.molcanovas@gmail.com>
       * @param string $prompt Prompt message
       * @return string
       */
      static function readline($prompt = null) {
         if ($prompt) {
            echo '[' . timestamp_precise() . '] ' . $prompt . ': ';
         }

         $r = trim(strtolower(stream_get_line(STDIN, PHP_INT_MAX, PHP_EOL)));
         echo PHP_EOL;

         return $r;
      }

   }

   IO::$argv = $_SERVER['argv'];
   array_shift(IO::$argv);