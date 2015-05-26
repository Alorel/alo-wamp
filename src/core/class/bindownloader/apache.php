<?php

   namespace BinDownloader;

   use Format;

   require_once 'bindownloadertrait.php';

   /**
    * Downloads Apache binaries
    *
    * @author Art <a.molcanovas@gmail.com>
    */
   class Apache extends \Setup\Apache {

      use BinDownloaderTrait;

      /**
       * Gets the installed versions
       *
       * @author Art <a.molcanovas@gmail.com>
       * @return Apache
       */
      protected function getInstalledVers() {
         $dir = DIR_APACHE;

         if(!file_exists($dir)) {
            die('Apache directory not found');
         } else {
            $scan = scandir($dir);
            Format::formatScandir($scan);
            $this->installed_vers = $scan;
         }

         return $this;
      }

   }