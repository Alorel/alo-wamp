<?php

   $services = [
      'alomemcache' => 'AloWAMP Memcache',
      'aloredis'    => 'AloWAMP Redis',
      'aloapache'   => 'AloWAMP Apache',
      'alomysql'    => 'AloWAMP MySQL'
   ];

   array_shift(IO::$argv);
   $launch = [];

   if (!IO::$argv) {
      $launch = array_keys($services);
   } else {
      $launch = IO::$argv;
   }