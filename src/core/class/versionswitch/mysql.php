<?php

   namespace VersionSwitch;

   /**
    * Switches MYSQL versions
    *
    * @author Art <a.molcanovas@gmail.com>
    */
   class MySQL extends AbstractVersionSwitch {

      /**
       * Constructor
       *
       * @author Art <a.molcanovas@gmail.com>
       */
      function __construct() {
         $this->ini     = 'mysql_version';
         $this->dir     = DIR_MYSQL;
         $this->service = 'alomysql';

         parent::__construct();
      }
   }