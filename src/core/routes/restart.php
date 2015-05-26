<?php

   require DIR_CORE . 'services.php';

   /** @var array $launch */
   foreach($launch as $s) {
      /** @var array $services */
      if(isset($services[$s])) {

         _echo('Restarting ' . $services[$s]);
         _echo(Service::restart($s));
      } else {
         _echo('Service ' . $s . ' not installed');
      }
   }