<?php

   if (\IO::readline('Are you sure you want to reset your installation? You will lose all configuration, but not your website data. [Y/N]') == 'y') {
      $items = [
         DIR_BIN,
         DIR_LOGS,
         DIR_TMP,
         DIR_CORE . 'settings.ini'
      ];

      foreach ($items as $i) {
         if (file_exists($i)) {
            if (is_dir($i)) {
               shell_exec('rd /s /q "' . rtrim($i, '\\/') . '"');
            } else {
               unlink($i);
            }
         }
      }

      _echo('Reset completed.');
   } else {
      _echo('Reset aborted');
   }