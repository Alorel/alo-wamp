<?php

   namespace VersionSwitch;

   class PHP extends AbstractVersionSwitch {

      function __construct() {
         $this->dependent_dirs = [DIR_APACHE];
         $this->ini = 'php_version';
         $this->dir = DIR_PHP;

         parent::__construct();
      }
   }