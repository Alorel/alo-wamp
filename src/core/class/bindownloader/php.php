<?php

   namespace BinDownloader;

   use Format;

   require_once 'bindownloadertrait.php';

   class PHP extends \Setup\PHP {

      use BinDownloaderTrait;

      /**
       * @return PHP
       */
      protected function getInstalledVers() {
         $dir = DIR_PHP;

         if(!file_exists($dir)) {
            die('PHP directory not found');
         } else {
            $scan = scandir($dir);
            Format::formatScandir($scan);
            $this->installed_vers = $scan;
         }

         return $this;
      }

   }