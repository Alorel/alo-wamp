<?php

   namespace VersionSwitch;

   /**
    * Switches PHP versions
    *
    * @author Art <a.molcanovas@gmail.com>
    */
   class PHP extends AbstractVersionSwitch {

      /**
       * Constructor
       *
       * @author Art <a.molcanovas@gmail.com>
       */
      function __construct() {
         $this->dependent_dirs = [DIR_APACHE];
         $this->ini = 'php_version';
         $this->dir = DIR_PHP;

         parent::__construct();
      }
   }