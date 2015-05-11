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

      /**
       * Downloader instance
       *
       * @var \Downloader
       */
      protected $downloader;

      protected $cleanup = false;

      protected function cleanup(array $files = []) {
         if ($this->cleanup) {
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
      }

      /**
       * @return PHP
       */
      protected function unzip() {
         _('Unzipping...');
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

      function __destruct() {
         $this->cleanup();
      }
   }