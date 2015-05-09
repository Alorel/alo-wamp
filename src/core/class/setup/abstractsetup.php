<?php

   namespace Setup;

   abstract class AbstractSetup {

      /**
       * @var string
       */
      protected $dest;

      /**
       * @var string
       */
      protected $dest_unzip;

      protected function cleanup(array $files = []) {
         $files = array_merge([$this->dest, $this->dest_unzip], $files);

         foreach ($files as $f) {
            if (file_exists($f)) {
               _('Cleaning up ' . $f);

               if (is_dir($f)) {
                  shell_exec('rd /s /q "' . $f . '"');
               } else {
                  unlink($f);
               }
            }
         }
      }

      function __destruct() {
         $this->cleanup();
      }
   }