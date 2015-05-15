<?php

   namespace BinChecker;

   use \cURL;
   use \DOMDocument;
   use \DOMXPath;
   use \DOMNode;

   /**
    * Checks for MySQL binary downloads
    *
    * @author Art <a.molcanovas@gmail.com>
    */
   class MySQL extends AbstractBinChecker {

      /**
       * Download host
       *
       * @var string
       */
      const HOST = 'http://dev.mysql.com';

      /**
       * Downloads the page
       *
       * @author Art <a.molcanovas@gmail.com>
       * @return MySQL
       */
      protected function downloadPage() {
         _echo('Loading MySQL download page');
         $this->curl = new cURL(self::HOST . '/downloads/mysql');
         $this->curl->exec();

         if ($this->curl->errno() != CURLE_OK) {
            die('Failed to load MySQL download page');
         } else {
            _echo('MySQL download page loaded');
            $this->raw_html = $this->curl->get();

         }

         return $this;
      }

      /**
       * Parses the page
       *
       * @author Art <a.molcanovas@gmail.com>
       * @return MySQL
       */
      protected function parsePage() {
         $d = new DOMDocument();
         @$d->loadhtml($this->raw_html);

         $xpath = new DOMXPath($d);

         $versions = $xpath->query('//b[contains(., "32-bit")]');

         /** @var DOMNode $v */
         foreach ($versions as $v) {
            $parent = $v->parentNode->parentNode;

            if ($parent) {
               $tr = new DOMDocument();
               @$tr->loadHTML($parent->C14N());
               $tr = new DOMXPath($tr);

               $ver = $tr->query('//td[contains(@class,"col3")]')->item(0);

               if ($ver) {
                  $ver = strip_tags($ver->C14N());

                  $link = $tr->query('//a[starts-with(@href,"/downloads/")]')->item(0);

                  if ($link) {
                     $matches = [];
                     preg_match('~"[a-z0-9\-\?\./=]+"~i', $link->C14N(), $matches);

                     if (!empty($matches)) {
                        $this->download_links[$ver] = self::HOST . trim($matches[0], ' "');
                     }
                  }
               }
            }
         }

         if (empty($this->download_links)) {
            _echo('No download links found.');
         } else {
            $this->getAcutalLinks();
         }

         return $this;
      }

      /**
       * Generates the actual download links (MySQL has a two-page thing for this)
       *
       * @author Art <a.molcanovas@gmail.com>
       * @return MySQL
       */
      protected function getAcutalLinks() {
         foreach ($this->download_links as $version => &$download_page) {
            $html = file_get_contents($download_page);

            if ($html) {
               $domdoc = new DOMDocument();
               @$domdoc->loadHTML($html);

               $xpath = new DOMXPath($domdoc);
               $link = $xpath
                  ->query('//a[contains(.,"No thanks, just start my download.")]')
                  ->item(0);

               if ($link) {
                  $matches = [];
                  preg_match('~"[a-z0-9\-\?\./=]+"~i', $link->C14N(), $matches);

                  if (!empty($matches)) {
                     $download_page = self::HOST . trim($matches[0], ' "');
                     continue;
                  }
               }
            }

            unset($this->download_links[$version]);
         }

         if (empty($this->download_links)) {
            _echo('No download links found.');
         } else {
            _echo(count($this->download_links) . ' MySQL versions found for download.');
         }

         return $this;
      }
   }