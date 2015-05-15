<?php

   namespace BinChecker;

   use \cURL;
   use \DOMDocument;
   use \DOMXPath;
   use \DOMNode;

   /**
    * Checks for Redis binary downloads
    *
    * @author Art <a.molcanovas@gmail.com>
    */
   class Redis extends AbstractBinChecker {

      /**
       * Download host
       *
       * @var string
       */
      const HOST = 'https://github.com/MSOpenTech/redis';

      /**
       * Parses the page
       *
       * @author Art <a.molcanovas@gmail.com>
       * @return Redis
       */
      protected function parsePage() {
         $d = new DOMDocument();
         @$d->loadhtml($this->raw_html);

         $xpath = new DOMXPath($d);
         $versions = @$xpath->query('//strong[contains(.,".zip")]');

         if ($versions) {
            $url_regex = '[a-z0-9\.\-_]+';
            $url_base = 'https://github.com/MSOpenTech/redis/releases/download/';
            /** @var DOMNode $strong */
            foreach ($versions as $strong) {
               $matches = [];
               preg_match('~' . $url_regex . '/' . $url_regex . '\.zip~i', $strong->parentNode->C14N(), $matches);

               if ($matches) {
                  $split = explode('/', $matches[0]);
                  $key = substr($split[0], 4);

                  $this->download_links[$key] = $url_base . implode('/', $split);
               }
            }
         } else {
            die('Failed to parse page');
         }

         return $this;
      }

      /**
       * Downloads the page
       *
       * @author Art <a.molcanovas@gmail.com>
       * @return Redis
       */
      protected function downloadPage() {
         _echo('Loading Redis download page');
         $this->curl = new cURL(self::HOST . '/releases');
         $this->curl->exec();

         if ($this->curl->errno() != CURLE_OK) {
            die('Failed to load Redis download page');
         } else {
            _echo('Redis download page loaded');
            $this->raw_html = $this->curl->get();
         }

         return $this;
      }
   }