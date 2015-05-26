<?php

   require DIR_CORE . 'services.php';

   /** @var array $launch */
   foreach($launch as $s) {
      /** @var array $services */
      if(isset($services[$s])) {

         _echo('Removing ' . $services[$s]);
         Service::delete($s);
      } else {
         _echo('Service ' . $s . ' not installed');
      }
   }