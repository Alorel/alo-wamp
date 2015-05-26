<?php

   namespace BinDownloader;

   use IO;

   /**
    * The trait all BinDownloaders share
    *
    * @author Art <a.molcanovas@gmail.com>
    */
   trait BinDownloaderTrait {

      /**
       * Currently installed versions
       *
       * @var array
       */
      protected $installed_vers;

      /**
       * Prevents service installation
       *
       * @author Art <a.molcanovas@gmail.com>
       * @return BinDownloaderTrait
       */
      protected function installService() {
         return $this;
      }

      /**
       * Prevents settings update
       *
       * @author Art <a.molcanovas@gmail.com>
       * @return BinDownloaderTrait
       */
      protected function updateSettings() {
         return $this;
      }

      /**
       * Filters download links
       *
       * @author Art <a.molcanovas@gmail.com>
       * @return BinDownloaderTrait
       */
      protected function filterLinks() {
         foreach($this->installed_vers as $v) {
            if(isset($this->links[$v])) {
               unset($this->links[$v]);
            }
         }

         return $this;
      }

      /**
       * Prompts to download a different version
       *
       * @author Art <a.molcanovas@gmail.com>
       * @return BinDownloaderTrait
       */
      protected function promptDownload() {
         $this->getInstalledVers()->filterLinks();
         if(!empty($this->links)) {
            $version_numbers = array_keys($this->links);
            _echo('The following versions were found for download (versions already installed are not included): ' .
                  PHP_EOL .
                  "\t"
                  .
                  implode(PHP_EOL . "\t", $version_numbers));

            $io = trim(IO::readline('Which version would you like to download? Input N to abort'));

            if(!$io) {
               $this->promptDownload();
            } elseif($io == 'n') {
               die('Aborting.');
            } elseif(!isset($this->links[$io])) {
               _echo('The version you selected is not available for download.');
               $this->promptDownload();
            } else {
               $this->version = $io;
               $this->download();

               return $this;
            }
         } else {
            die('There are no versions available to download that aren\'t installed already.');
         }

         return $this;
      }
   }