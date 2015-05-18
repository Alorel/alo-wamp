<?php

   namespace Setup;

   /**
    * Abstract setup class
    *
    * @author Art <a.molcanovas@gmail.com>
    */
   abstract class AbstractSetup {

      /**
       * Where to download
       *
       * @var string
       */
      protected $dest;

      /**
       * Where to unzip
       *
       * @var string
       */
      protected $dest_unzip;

      /**
       * Downloader instance
       *
       * @var \Downloader
       */
      protected $downloader;

      /**
       * Whether a cleanup should be performed
       *
       * @var bool
       */
      protected $cleanup = true;

      /**
       * Cleans up in tmp
       *
       * @author Art <a.molcanovas@gmail.com>
       * @param array $files Files to clear
       * @return AbstractSetup
       */
      protected function cleanup(array $files = []) {
         if ($this->cleanup) {
            $files = array_merge([$this->dest, $this->dest_unzip], $files);

            foreach ($files as $f) {
               if (file_exists($f)) {
                  _echo('Cleaning up ' . $f);

                  if (is_dir($f)) {
                     shell_exec('rd /s /q "' . $f . '"');
                  } else {
                     unlink($f);
                  }
               }
            }
         }

         return $this;
      }

      /**
       * Unzips downloaded contents
       *
       * @author Art <a.molcanovas@gmail.com>
       * @return AbstractSetup
       */
      protected function unzip() {
         _echo('Unzipping...');
         $zip = new \ZipArchive();
         $res = $zip->open($this->dest);

         if ($res === true) {
            if (file_exists($this->dest_unzip)) {
               shell_exec('rd /s /q "' . rtrim($this->dest_unzip, '\\/') . '"');
            }

            $zip->extractTo($this->dest_unzip);
            $zip->close();
         } else {
            die('Failed to unzip ' . $this->dest . '. Terminating.');
         }

         return $this;
      }

      /**
       * Performs cleanup if needed
       *
       * @author Art <a.molcanovas@gmail.com>
       */
      function __destruct() {
         $this->cleanup();
      }
   }