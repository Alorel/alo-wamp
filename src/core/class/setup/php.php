<?php

   namespace Setup;

   use \Downloader;
   use \Settings as SET;

   class PHP extends AbstractSetup {

      /**
       * @var \BinChecker\PHP
       */
      protected $binchecker;

      /**
       * @var array
       */
      protected $links;

      protected $version = '5.6.8';

      protected $unzipped_destination = 'W:\Dropbox\sync\dev\misc\AloWAMP\src\bin\php\5.6.8\\';

      function __construct() {
         $this->dest = DIR_TMP . 'php.zip';
         $this->dest_unzip = DIR_TMP . 'php' . DIRECTORY_SEPARATOR;

         $this->binchecker = new \BinChecker\PHP();
         $this->links = $this->binchecker->getLinks();

         $this
            ->promptDownload()
            ->unzip()
            ->copy()
            ->renameIni()
            ->setTimezone();
      }

      protected function setTimezone() {
         $timezone = SET::$s->php_date_timezone;
         $ini = $this->unzipped_destination . 'php.ini';

         if (!$timezone) {
            $timezone = 'Europe/London';
            SET::$s->php_date_timezone = $timezone;
            SET::$s->save();
         }

         //Only continue if timezone isn't already set
         if (!isset(parse_ini_file($ini)['date.timezone'])) {
            $contents = file_get_contents($ini);

            if ($contents) {
               $contents = str_replace(';date.timezone =', 'date.timezone = ' . $timezone, $contents);

               if (file_put_contents($ini, $contents) !== false) {
                  _('Set the timezone in php.ini to ' . $timezone);
               } else {
                  _('Failed to set the timezone in php.ini. You will have to set the timezone yourself.');
               }
            } else {
               _('Failed to open php.ini for editing. You will have to set the timezone yourself.');
            }
         } else {
            _('date.timezone already had a preset value - no change made');
         }
      }

      /**
       * @return PHP
       */
      protected function renameIni() {
         if (!file_exists($this->unzipped_destination . 'php.ini')) {
            $file = null;
            if (file_exists($this->unzipped_destination . 'php.ini-development')) {
               $file = $this->unzipped_destination . 'php.ini-development';
            } elseif (file_exists($this->unzipped_destination . 'php.ini-production')) {
               $file = $this->unzipped_destination . 'php.ini-production';
            } else {
               die('Could not find sample php.ini. Aborting.');
            }

            copy($file, $this->unzipped_destination . 'php.ini');

            if (!file_exists($this->unzipped_destination . 'php.ini')) {
               die('Failed to copy sample php.ini. Aborting.');
            } else {
               _('Sample php.ini copied');
            }
         } else {
            _('php.ini found');
         }

         return $this;
      }

      /**
       * PHP
       */
      protected function copy() {
         _('Copying unzipped contents..');

         $source = rtrim($this->dest_unzip, DIRECTORY_SEPARATOR);
         $this->unzipped_destination = DIR_BIN . 'php' . DIRECTORY_SEPARATOR . $this->version;

         if (!file_exists($this->unzipped_destination)) {
            mkdir($this->unzipped_destination . DIRECTORY_SEPARATOR, 777, true);
         }

         shell_exec('xcopy /s /e "' . $source . '" "' . $this->unzipped_destination . '"');

         $this->unzipped_destination .= DIRECTORY_SEPARATOR;

         if (file_exists($this->unzipped_destination . 'php.ini-development') || file_exists($this->unzipped_destination . 'php.ini')) {
            _('Copy successful!');
         } else {
            die('Failed to copy. Terminating setup.');
         }

         return $this;
      }

      /**
       * @return PHP
       */
      protected function promptDownload() {
         if (!empty($this->links)) {
            $version_numbers = array_keys($this->links);
            _('The following versions were found for download: ' . PHP_EOL . "\t"
               . implode(PHP_EOL . "\t", $version_numbers));

            $io = trim(\IO::readline('Which version would you like to download? Input N to abort'));

            if (!$io) {
               $this->promptDownload();
            } elseif ($io == 'n') {
               die('Aborting.');
            } elseif (!isset($this->links[$io])) {
               _('The version you selected is not available for download.');
               $this->promptDownload();
            } else {
               $this->version = $io;
               $this->downloader = new Downloader($this->links[$io], $this->dest);

               if ($this->downloader->download()) {
                  _('Download successful. Setting up PHP ' . $io);
                  sleep(1);
               } else {
                  die('Download failed. Aborting setup.');
               }

               return $this;
            }
         } else {
            die('Aborting.');
         }

         return $this;
      }
   }