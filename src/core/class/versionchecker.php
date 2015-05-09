<?php

   /**
    * Checks if you have the most up-to-date version of AloWAMP
    * @author Art <a.molcanovas@gmail.com>
    */
   class VersionChecker {

      /**
       * URL to check
       * @var string
       */
      protected static $url = 'https://raw.githubusercontent.com/Alorel/AloWAMP/master/src/VERSION';

      /**
       * @var
       */
      protected $curl;
   }