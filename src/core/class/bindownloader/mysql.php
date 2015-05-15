<?php

   namespace BinDownloader;

   use \Format;

   require_once 'bindownloadertrait.php';

   /**
    * Downloads MySQL binaries
    *
    * @author Art <a.molcanovas@gmail.com>
    */
   class MySQL extends \Setup\MySQL {

      use BinDownloaderTrait;

      /**
       * Gets the currently installed versions
       *
       * @author Art <a.molcanovas@gmail.com>
       * @return MySQL
       */
      protected function getInstalledVers() {
         $dir = DIR_MYSQL;

         if (!file_exists($dir)) {
            die('MySQL directory not found');
         } else {
            $scan = scandir($dir);
            Format::formatScandir($scan);
            $this->installed_vers = $scan;
         }

         return $this;
      }
   }