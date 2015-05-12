<?php

   namespace BinChecker;

   use \cURL;
   use \DOMDocument;
   use \DOMXPath;
   use \DOMNode;

   class PHP extends AbstractBinChecker {

      const HOST = 'http://windows.php.net';

      protected function parsePage() {
         $d = new DOMDocument();
         @$d->loadhtml($this->raw_html);

         $xpath = new DOMXPath($d);

         $versions = $xpath->query('//h3[starts-with(@id, "php-")]');

         /** @var DOMNode $v */
         foreach ($versions as $v) {
            $matches = [];
            preg_match('~\([0-9\.]+\)~', strip_tags($v->C14N()), $matches);

            if (!empty($matches)) {
               $version = trim($matches[0], '() ');
               $dl = @$xpath->query('//a[starts-with(@href, "/downloads/releases/php-' . $version . '-Win32")]');

               if ($dl) {
                  $dl_link = null;
                  /** @var DOMNode $link */
                  foreach ($dl as $link) {
                     $c14 = $link->C14N();

                     if (stripos($c14, '.zip') !== false) {
                        $l = [];
                        preg_match('~"[/a-z0-9\-.]+"~i', $link->C14N(), $l);

                        if (!empty($l)) {
                           $dl_link = self::HOST . trim($l[0], ' "');
                           break;
                        }
                     }
                  }

                  if ($dl_link) {
                     $this->download_links[$version] = $dl_link;
                  }
               }
            }
         }

         if (empty($this->download_links)) {
            _echo('No download links found.');
         } else {
            _echo(count($this->download_links) . ' PHP versions found for download.');
         }

         return $this;
      }

      /**
       * @return PHP
       */
      protected function downloadPage() {
         _echo('Loading PHP download page');
         $this->curl = new cURL(self::HOST . '/download/');
         $this->curl->exec();

         if ($this->curl->errno() != CURLE_OK) {
            die('Failed to load PHP download page');
         } else {
            _echo('PHP download page loaded');
            $this->raw_html = $this->curl->get();
         }

         return $this;
      }
   }