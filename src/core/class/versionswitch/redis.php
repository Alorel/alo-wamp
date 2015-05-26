<?php

   namespace VersionSwitch;

   /**
    * Switches Redis versions
    *
    * @author Art <a.molcanovas@gmail.com>
    */
   class Redis extends AbstractVersionSwitch {

      /**
       * Constructor
       *
       * @author Art <a.molcanovas@gmail.com>
       */
      function __construct() {
         $this->ini     = 'redis_version';
         $this->dir     = DIR_REDIS;
         $this->service = 'aloredis';

         parent::__construct();
      }
   }