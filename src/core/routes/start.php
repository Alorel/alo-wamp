<?php

   require DIR_CORE . 'services.php';

   /** @var array $launch */
   foreach ($launch as $s) {
      /** @var array $services */
      if (isset($services[$s])) {

         _echo('Starting ' . $services[$s]);
         Service::start($s);
      } else {
         _echo('Service ' . $s . ' not installed');
      }
   }