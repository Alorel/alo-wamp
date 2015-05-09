<?php

   namespace Setup;

   use \Downloader;

   class Memcache extends AbstractSetup {

      /**
       * Memcache download source url
       *
       * @var string
       */
      const MEMCACHE_DOWNLOAD_SOURCE = 'https://github.com/Alorel/AloWAMP/archive/bin/memcached.zip';

      /**
       * Downloader instance
       *
       * @var Downloader
       */
      protected $downloader;

      function __construct() {
         $this->dest = DIR_TMP . 'memcache.zip';
         $this->dest_unzip = DIR_TMP . 'AloWAMP-bin-memcached' . DIRECTORY_SEPARATOR;
         $this->download()
            ->unzip()
            ->copy();
      }

      /**
       * @return Memcache
       */
      protected function unzip() {
         _('Unzipping...');
         $zip = new \ZipArchive();
         $res = $zip->open($this->dest);

         if ($res === true) {
            if (file_exists($this->dest_unzip)) {
               rmdir($this->dest_unzip);
            }

            $zip->extractTo(DIR_TMP);
            $zip->close();
         } else {
            die('Failed to unzip ' . $this->dest . '. Terminating.');
         }

         return $this;
      }

      protected function copy() {
         _('Copying unzipped contents..');

         shell_exec('xcopy /s /e "' . rtrim($this->dest_unzip, DIRECTORY_SEPARATOR) . '" "' . rtrim(DIR_INDEX, DIRECTORY_SEPARATOR) . '"');

         if (file_exists(DIR_INDEX . 'README.md')) {
            unlink(DIR_INDEX . 'README.md');
         }

         if (file_exists(DIR_MEMCACHE)) {
            _('Copy successful!');
         } else {
            die('Failed to copy. Terminating setup.');
         }
      }

      /**
       * Downloads memcache
       *
       * @author Art <a.molcanovas@gmail.com>
       */
      protected function download() {
         $this->downloader = new Downloader(self::MEMCACHE_DOWNLOAD_SOURCE, $this->dest);

         if ($this->downloader->download()) {
            _('Download successful. Setting up Memcache...');
            sleep(3);
         } else {
            die('Download failed. Aborting setup.');
         }

         return $this;
      }
   }