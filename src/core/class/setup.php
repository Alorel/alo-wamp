<?php

   /**
    * Setup script walkthrough
    *
    * @author Art <a.molcanovas@gmail.com>
    */
   class Setup {

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
            mkdir($path, 777, true);
            _($msg . ' created');
         }

         return $this;
      }

      /**
       * @return Setup
       */
      function checkDateTimezone() {
         if (Settings::$s->{'php_date_timezone'}) {
            _('PHP\'s date.timezone OK');
         } else {
            $timezone = trim(IO::readline('Please input the timezone for PHP, e.g. Europe/London]'));

            if (!$timezone) {
               $this->checkDateTimezone();
            } else {
               $split = explode('/', $timezone);
               foreach ($timezone as &$t) {
                  $t = trim(ucfirst($t));
               }

               Settings::$s->php_date_timezone = implode('/', $timezone);
               Settings::$s->save();
               _('Timezone set');
            }
         }

         return $this;
      }

      function checkWWW() {
         if (file_exists(DIR_WWW)) {
            _('www dir OK');
         } else {
            _('www directory not found. Creating...');

            $dir = DIR_WWW . 'my-default-website' . DIRECTORY_SEPARATOR;
            mkdir($dir, 777, true);
            file_put_contents($dir . 'index.html', 'Yep, you\'re up.');
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