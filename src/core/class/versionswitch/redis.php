<?php

   namespace VersionSwitch;

   class Redis extends AbstractVersionSwitch {

      function __construct() {
         $this->ini = 'redis_version';
         $this->dir = DIR_REDIS;
         $this->service = 'aloredis';

         parent::__construct();
      }
   }