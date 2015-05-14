<?php

   namespace Service;

   abstract class Redis extends Service {

      static function installExe($service_name, $exe_path, $display_name = null, $params = null) {
         $cmd = '"' . $exe_path . '" --service-install --service-name "' . $display_name . '"';

         if ($params) {
            $cmd .= ' ' . $params;
         }

         return shell_exec($cmd);
      }
   }