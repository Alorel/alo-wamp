<?php

   namespace VersionSwitch;

   /**
    * Switches Apache HTTPD versions
    *
    * @author Art <a.molcanovas@gmail.com>
    */
   class Apache extends AbstractVersionSwitch {

      /**
       * Constructor
       *
       * @author Art <a.molcanovas@gmail.com>
       */
      function __construct() {
         $this->ini = 'apache_version';
         $this->dir = DIR_APACHE;
         $this->service = 'aloapache';

         parent::__construct();
      }
   }