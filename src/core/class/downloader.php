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
       * @var int
       */
      protected $last_report_time;

      /**
       * @var float
       */
      protected $last_report_status;

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
         $ed = $size = 0;

         if ($download_size > 0 && $downloaded > 0) {
            $ed = $downloaded;
            $size = $download_size;
         } elseif ($upload_size > 0 && $uploaded > 0) {
            $ed = $uploaded;
            $size = $upload_size;
         }

         if ($ed && $size) {
            $status = Format::filesize($ed) . '/' . Format::filesize($size) . ' downloaded ['
               . round(($ed / $size) * 100, 3) . ' %]';

            $time = time();
            if ($status != $this->last_report_status && ($time != $this->last_report_time || $ed == $size)) {
               $this->last_report_time = $time;
               $this->last_report_status = $status;
               _echo($status);
            }
         }

         unset($resource);
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
            _echo($this->curl->error());

            return false;
         }
      }
   }