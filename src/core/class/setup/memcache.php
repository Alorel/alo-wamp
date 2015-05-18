<?php

   namespace Setup;

   use \Service;

   /**
    * Sets up Memcache
    *
    * @author Art <a.molcanovas@gmail.com>
    */
   class Memcache extends AbstractSetup {

      /**
       * Memcache download source url
       *
       * @var string
       */
      const MEMCACHE_DOWNLOAD_SOURCE = 'https://github.com/Alorel/AloWAMP/archive/bin/memcached.zip';

      /**
       * Constructor
       *
       * @author Art <a.molcanovas@gmail.com>
       */
      function __construct() {
         $this->dest = DIR_TMP . 'memcache.zip';
         $this->dest_unzip = DIR_TMP . 'AloWAMP-bin-memcached' . DIRECTORY_SEPARATOR;
         $this->download()
            ->unzip()
            ->copy()
            ->installService();
      }

      /**
       * Installs the service
       *
       * @author Art <a.molcanovas@gmail.com>
       * @return Memcache
       */
      protected function installService() {
         if (Service::exists('alomemcache')) {
            _echo('Removing previous AloWAMP Memcache service');
            _echo(Service::delete('alomemcache'));
         }

         _echo('Installing Memcache service');
         _echo(Service::installExe('alomemcache', DIR_MEMCACHE . 'memcached.exe -d runservice', 'AloWAMP Memcache'));

         return $this;
      }

      /**
       * Copies unzipped contents
       *
       * @author Art <a.molcanovas@gmail.com>
       * @return Memcache
       */
      protected function copy() {
         _echo('Copying unzipped contents..');

         shell_exec('xcopy /s /e "' . rtrim($this->dest_unzip, DIRECTORY_SEPARATOR) . '" "' . rtrim(DIR_INDEX, DIRECTORY_SEPARATOR) . '"');

         if (file_exists(DIR_INDEX . 'README.md')) {
            unlink(DIR_INDEX . 'README.md');
         }

         if (file_exists(DIR_MEMCACHE)) {
            _echo('Copy successful!');
            $this->cleanup();
         } else {
            die('Failed to copy. Terminating setup.');
         }

         return $this;
      }

      /**
       * Unzips contents
       *
       * @author Art <a.molcanovas@gmail.com>
       * @return Memcache
       */
      protected function unzip() {
         _echo('Unzipping...');
         $zip = new \ZipArchive();
         $res = $zip->open($this->dest);

         if ($res === true) {
            if (file_exists($this->dest_unzip)) {
               rmdir($this->dest_unzip);
            }

            $zip->extractTo(DIR_TMP);
            $zip->close();
         } else {
            die('Failed to unzip ' . $this->dest . '. Terminating.');
         }

         return $this;
      }

      /**
       * Downloads memcache
       *
       * @author Art <a.molcanovas@gmail.com>
       * @return Memcache
       */
      protected function download() {
         $this->downloader = new \Downloader(self::MEMCACHE_DOWNLOAD_SOURCE, $this->dest);

         if ($this->downloader->download()) {
            _echo('Download successful. Setting up Memcache...');
         } else {
            die('Download failed. Aborting setup.');
         }

         return $this;
      }
   }