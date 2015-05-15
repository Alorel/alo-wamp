<?php

   namespace BinChecker;

   use \cURL;

   /**
    * Abstract binary checker
    *
    * @author Art <a.molcanovas@gmail.com>
    */
   abstract class AbstractBinChecker {

      /**
       * cURL instance
       *
       * @var cURL
       */
      protected $curl;

      /**
       * Raw page HTML to parse
       *
       * @var string
       */
      protected $raw_html;

      /**
       * Array of download versions and links
       *
       * @var array
       */
      protected $download_links;

      /**
       * The parsed page
       *
       * @var array
       */
      protected $page_parsed;

      /**
       * Instantiates the class
       *
       * @author Art <a.molcanovas@gmail.com>
       */
      function __construct() {
         $this->download_links = [];
         $this
            ->downloadPage()
            ->parsePage();
      }

      /**
       * Returns the download links
       *
       * @author Art <a.molcanovas@gmail.com>
       * @return array
       */
      function getLinks() {
         return $this->download_links;
      }

      /**
       * Downloads the page
       *
       * @author Art <a.molcanovas@gmail.com>
       * @return AbstractBinChecker
       */
      protected abstract function downloadPage();

      /**
       * Parses the page
       *
       * @author Art <a.molcanovas@gmail.com>
       * @return AbstractBinChecker
       */
      protected abstract function parsePage();
   }