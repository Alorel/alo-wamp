<?php

   namespace Setup;

   use \Downloader;

   class Memcache {

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
         $this->download();
      }

      /**
       * Downloads memcache
       *
       * @author Art <a.molcanovas@gmail.com>
       */
      protected function download() {
         $this->downloader = new Downloader(self::MEMCACHE_DOWNLOAD_SOURCE, DIR_TMP . 'memcache.zip');

         if ($this->downloader->download()) {
            echo PHP_EOL . 'Download successful. Setting up...' . PHP_EOL;
         } else {
            die('Download failed. Aborting setup.');
         }

         return $this;
      }
   }