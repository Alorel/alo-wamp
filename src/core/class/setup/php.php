<?php

   namespace Setup;

   use \Downloader;

   class PHP extends AbstractSetup {

      /**
       * @var \BinChecker\PHP
       */
      protected $binchecker;

      /**
       * @var array
       */
      protected $links;

      protected $version;

      function __construct() {
         $this->dest = DIR_TMP . 'php.zip';
         $this->dest_unzip = DIR_TMP . 'php' . DIRECTORY_SEPARATOR;

         $this->binchecker = new \BinChecker\PHP();
         $this->links = $this->binchecker->getLinks();

         $this
            ->promptDownload()
            ->unzip();
      }

      function unzip() {

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
                  sleep(3);
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