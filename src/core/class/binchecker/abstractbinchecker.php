<?php

   namespace BinChecker;

   use \cURL;

   abstract class AbstractBinChecker {

      /**
       * @var cURL
       */
      protected $curl;

      /**
       * @var string
       */
      protected $raw_html;

      /**
       * @var array
       */
      protected $download_links;

      /**
       * @var array
       */
      protected $page_parsed;

      function __construct() {
         $this->download_links = [];
         $this
            ->downloadPage()
            ->parsePage();
      }

      function getLinks() {
         return $this->download_links;
      }

      /**
       * @return AbstractBinChecker
       */
      protected abstract function downloadPage();

      /**
       * @return AbstractBinChecker
       */
      protected abstract function parsePage();
   }