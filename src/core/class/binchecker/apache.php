<?php

   namespace BinChecker;

   use \cURL;
   use \DOMDocument;
   use \DOMXPath;
   use \DOMNode;

   /**
    * Checks for Apache binary downloads
    *
    * @author Art <a.molcanovas@gmail.com>
    */
   class Apache extends AbstractBinChecker {

      /**
       * The download host
       *
       * @var string
       */
      const HOST = 'http://www.apachelounge.com/';

      /**
       * Downloads the page
       *
       * @author Art <a.molcanovas@gmail.com>
       * @return Apache
       */
      protected function downloadPage() {
         _echo('Loading Apache download page');
         $this->curl = new cURL(self::HOST . '/download/');
         $this->curl->exec();

         if ($this->curl->errno() != CURLE_OK) {
            die('Failed to load Apache download page');
         } else {
            _echo('Apache download page loaded');
            $this->raw_html = $this->curl->get();
         }

         return $this;
      }

      /**
       * Parses the page
       *
       * @author Art <a.molcanovas@gmail.com>
       * @return Apache
       */
      protected function parsePage() {
         $d = new DOMDocument();
         @$d->loadhtml($this->raw_html);

         $xpath = new DOMXPath($d);

         $versions = $xpath->query('//a[starts-with(@href, "/download/VC11/binaries/")]');

         /** @var DOMNode $v */
         foreach ($versions as $v) {
            $c14 = $v->C14N();

            if (stripos($c14, '.zip"') !== false && stripos($c14, '-win32-') !== false) {
               $matches = [];
               preg_match('~"[/a-z0-9\-.]+"~i', $c14, $matches);

               if (!empty($matches)) {
                  $matches = $matches[0];
                  $link = explode('-win32-', explode('httpd-', $matches)[1])[0];
                  $this->download_links[$link] = self::HOST . trim($matches, ' "');
               }
            }
         }

         if (empty($this->download_links)) {
            _echo('No download links found.');
         } else {
            _echo(count($this->download_links) . ' Apache HTTPD versions found for download.');
         }

         return $this;
      }

   }