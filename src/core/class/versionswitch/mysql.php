<?php

   namespace VersionSwitch;

   class MySQL extends AbstractVersionSwitch {

      function __construct() {
         $this->ini = 'mysql_version';
         $this->dir = DIR_MYSQL;
         $this->service = 'alomysql';

         parent::__construct();
      }
   }