<?php

   abstract class Service {

      static function exists($name) {
         return trim(shell_exec(SERVICEEXISTS . ' ' . $name)) == 'OK';
      }

      static function delete($name) {
         return self::stop($name) . PHP_EOL . shell_exec('sc delete ' . $name);
      }

      static function stop($name) {
         return shell_exec('sc stop ' . $name);
      }

      static function start($name) {
         return shell_exec('sc start ' . $name);
      }

      static function restart($name) {
         return self::stop($name) . PHP_EOL . self::start($name);
      }

      static function installExe($service_name, $exe_path, $display_name = null, $params = null) {
         $cmd = 'sc create ' . $service_name . ' binPath= "' . $exe_path . '"';

         if ($display_name) {
            $cmd .= ' DisplayName= "' . $display_name . '"';
         }

         if ($params) {
            $cmd .= ' ' . $params;
         }

         return shell_exec($cmd);
      }
   }