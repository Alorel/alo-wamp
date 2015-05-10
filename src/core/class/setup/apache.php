<?php

   namespace Setup;

   use \Format;
   use \Settings as SET;

   class Apache extends AbstractBinSetup {

      /**
       * @var \BinChecker\Apache
       */
      protected $binchecker;

      function __construct() {
         $this->cleanup = false;
         $this->dest = DIR_TMP . 'httpd.zip';
         $this->dest_unzip = DIR_TMP . 'httpd' . DIRECTORY_SEPARATOR;

         $this->binchecker = new \BinChecker\Apache();
         $this->links = $this->binchecker->getLinks();

         $this->version = '2.4.12';

         $this
            //->promptDownload()
            //->unzip()
            ->copy();
      }

      /**
       * @return Apache
       */
      protected function copy() {
         $scan = scandir($this->dest_unzip);
         Format::formatScandir($scan);
         $dir = null;

         foreach ($scan as $s) {
            if (is_dir($this->dest_unzip . $s)) {
               $dir = $this->dest_unzip . $s;
               break;
            }
         }

         if (!$dir) {
            die('Could not find the apache source directory in the unzipped files. Aborting.');
         } else {
            _('Copying downloaded contents...');
            $source = $dir;
            $this->unzipped_destination = DIR_APACHE . $this->version;

            if (!file_exists($this->unzipped_destination . DIRECTORY_SEPARATOR)) {
               mkdir($this->unzipped_destination . DIRECTORY_SEPARATOR, 777, true);
            }

            shell_exec('xcopy /s /e "' . $source . '" "' . $this->unzipped_destination . '"');
            $this->unzipped_destination .= DIRECTORY_SEPARATOR;

            if (file_exists($this->unzipped_destination . 'bin')) {
               _('Copy successful!');
               $this->updateSettings();
            } else {
               die('Failed to copy. Terminating setup.');
            }

         }

         return $this;
      }

      /**
       * @return Apache
       */
      protected function updateSettings() {
         SET::$s->apache_version = $this->version;
         SET::$s->save();

         return $this;
      }
   }