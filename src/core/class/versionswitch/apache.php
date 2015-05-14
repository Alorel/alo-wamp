<?php

   namespace VersionSwitch;

   class Apache extends AbstractVersionSwitch {

      function __construct() {
         $this->ini = 'apache_version';
         $this->dir = DIR_APACHE;
         $this->service = 'aloapache';

         parent::__construct();
      }
   }