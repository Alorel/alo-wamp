<?php

   ob_start();

   include_once __DIR__ . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . 'core' . DIRECTORY_SEPARATOR . 'core.php';

   define('PHPUNIT_ROOT', __DIR__ . DIRECTORY_SEPARATOR);

   define('PHPUNIT_RUNNING', true);

   function _unit_dump($data) {
      ob_start();
      var_dump($data);

      return ob_get_clean();
   }