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
            _('Temporary directory OK');
         } else {
            mkdir(DIR_TMP, 777, true);
            _('Temporary directory created');
         }

         return $this;
      }

      /**
       * Checks if a directory exists
       *
       * @return Setup
       */
      function checkDir($path, $msg = null) {
         if (!$msg) {
            $msg = $path;
         }

         if (file_exists($path)) {
            _($msg . ' OK');
         } else {
            mkdir(DIR_BIN, 777, true);
            _($msg . ' created');
         }

         return $this;
      }

      /**
       * @return Setup
       */
      function checkBin() {
         if (file_exists(DIR_BIN)) {
            _('bin directory OK');
         } else {
            mkdir(DIR_BIN, 777, true);
            _('Bin directory created');
         }

         return $this;
      }

      /**
       * Checks and creates the memcache directory
       *
       * @return Setup
       */
      function checkMemcache() {
         if (file_exists(DIR_MEMCACHE)) {
            _('Memcache OK');
         } else {
            _('Memcache not found. Contacting download server...');
            sleep(3);
            new \Setup\Memcache();
         }

         return $this;
      }
   }