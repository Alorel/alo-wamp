<?php

   /**
    * Downloads stuff
    *
    * @author Art <a.molcanovas@gmail.com>
    */
   class Downloader {

      /**
       * cURL handler
       *
       * @var cURL
       */
      protected $curl;

      /**
       * Download destination
       *
       * @var string
       */
      protected $dest;

      /**
       * The last reported status
       *
       * @var string
       */
      protected $last_reported_status;

      /**
       * Output
       *
       * @var resource
       */
      protected $fp;

      function __construct($source, $destination) {
         $this->dest = $destination;
         $this->curl = new cURL($source);
         $this->curl->setProgressFunction([$this, 'progressFunction']);
      }

      function progressFunction($resource, $download_size, $downloaded, $upload_size, $uploaded) {
         if ($download_size > 0 && $downloaded > 0) {
            $status = ($downloaded / $download_size) * 100;
            if ($status != $this->last_reported_status) {
               $this->last_reported_status = $status;
               _(round(($downloaded / $download_size) * 100, 3) . '%');
            }
         }
      }

      function download() {
         if (file_exists($this->dest)) {
            unlink($this->dest);
         }

         $this->fp = fopen($this->dest, 'w');
         $this->curl->setopt(CURLOPT_FILE, $this->fp);
         $this->curl->exec();
         fclose($this->fp);

         $errno = $this->curl->errno();

         if ($errno === CURLE_OK) {
            return true;
         } else {
            _($this->curl->error());

            return false;
         }
      }
   }