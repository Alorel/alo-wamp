<?php

   namespace BinDownloader;

   use Format;

   require_once 'bindownloadertrait.php';

   class Redis extends \Setup\Redis {

      use BinDownloaderTrait;

      protected $installed_vers;

      /**
       * @return Redis
       */
      protected function getInstalledVers() {
         $dir = DIR_REDIS;

         if(!file_exists($dir)) {
            die('Redis directory not found');
         } else {
            $scan = scandir($dir);
            Format::formatScandir($scan);
            $this->installed_vers = $scan;
         }

         return $this;
      }

   }