<?php

   namespace BinChecker;

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
       * @return AbstractChecker
       */
      protected abstract function downloadPage();

      /**
       * @return AbstractChecker
       */
      protected abstract function parsePage();
   }