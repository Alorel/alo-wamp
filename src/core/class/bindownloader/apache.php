<?php

   namespace BinDownloader;

   use \Format;
   use \IO;

   class Apache extends \Setup\Apache {

      protected $installed_vers;

      /**
       * @return Apache
       */
      protected function getInstalledVers() {
         $dir = DIR_APACHE;

         if (!file_exists($dir)) {
            die('Apache directory not found');
         } else {
            $scan = scandir($dir);
            Format::formatScandir($scan);
            $this->installed_vers = $scan;
         }

         return $this;
      }

      /**
       * @return Apache
       */
      protected function installService() {
         return $this;
      }

      /**
       * @return Apache
       */
      protected function filterLinks() {
         foreach ($this->installed_vers as $v) {
            if (isset($this->links[$v])) {
               unset($this->links[$v]);
            }
         }

         return $this;
      }

      /**
       * @return Apache
       */
      protected function updateSettings() {
         return $this;
      }

      /**
       * @return Apache
       */
      protected function promptDownload() {
         $this->getInstalledVers()->filterLinks();
         if (!empty($this->links)) {
            $version_numbers = array_keys($this->links);
            _echo('The following versions were found for download (versions already installed are not included): ' . PHP_EOL . "\t"
               . implode(PHP_EOL . "\t", $version_numbers));

            $io = trim(IO::readline('Which version would you like to download? Input N to abort'));

            if (!$io) {
               $this->promptDownload();
            } elseif ($io == 'n') {
               die('Aborting.');
            } elseif (!isset($this->links[$io])) {
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