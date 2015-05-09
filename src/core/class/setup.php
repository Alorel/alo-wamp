<?php

   /**
    * Setup script walkthrough
    *
    * @author Art <a.molcanovas@gmail.com>
    */
   class Setup {

      /**
       * Checks and creates the temporary directory
       *
       * @author Art <a.molcanovas@gmail.com>
       * @return Setup
       */
      function checkTMP() {
         if (file_exists(DIR_TMP)) {
            echo 'Temporary directory OK';
         } else {
            mkdir(DIR_TMP, 777, true);
            echo 'Temporary directory created';
         }

         echo PHP_EOL;

         return $this;
      }

      /**
       * Checks and creates the memcache directory
       *
       * @return Setup
       */
      function checkMemcache() {
         if (file_exists(DIR_MEMCACHE)) {
            echo 'Memcache OK';
         } else {
            if (IO::readline('Memcache not found. Would you like to download it? [Y/N]') == 'y') {
               echo 'Contacting download server...' . PHP_EOL;
               new \Setup\Memcache();
            } else {
               die('Setup aborted');
            }
         }

         echo PHP_EOL;

         return $this;
      }
   }