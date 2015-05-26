<?php

   /**
    * Service handler
    *
    * @author Art <a.molcanovas@gmail.com>
    */
   abstract class Service {

      /**
       * Checks if a service exists
       *
       * @author Art <a.molcanovas@gmail.com>
       *
       * @param string $name Service name
       *
       * @return bool
       */
      static function exists($name) {
         return trim(shell_exec(SERVICEEXISTS . ' ' . $name)) == 'OK';
      }

      /**
       * Deletes a service
       *
       * @author Art <a.molcanovas@gmail.com>
       *
       * @param string $name Service name
       *
       * @return string shell_exec() output
       */
      static function delete($name) {
         return self::stop($name) . PHP_EOL . shell_exec('sc delete ' . $name);
      }

      /**
       * Stops a service
       *
       * @author Art <a.molcanovas@gmail.com>
       *
       * @param string $name Service name
       *
       * @return string shell_exec() output
       */
      static function stop($name) {
         return shell_exec('sc stop ' . $name);
      }

      /**
       * Starts a service
       *
       * @author Art <a.molcanovas@gmail.com>
       *
       * @param string $name Service name
       *
       * @return string shell_exec() output
       */
      static function start($name) {
         return shell_exec('sc start ' . $name);
      }

      /**
       * Checks if a service is running
       *
       * @author Art <a.molcanovas@gmail.com>
       *
       * @param string $name
       *
       * @return bool
       */
      static function is_running($name) {
         $e         = shell_exec("sc query $name");
         $e         = explode("\n", $e);
         $state_row = null;

         foreach($e as $row) {
            if(strpos($row, 'STATE') !== false) {
               $state_row = $row;
               break;
            }
         }

         return $state_row && (strpos($state_row, 'STOPPED') !== false);
      }

      /**
       * Restarts a service
       *
       * @author Art <a.molcanovas@gmail.com>
       *
       * @param string $name Service name
       *
       * @return string shell_exec() output
       */
      static function restart($name) {
         if(self::is_running($name)) {
            do {
               self::stop($name);
               sleep(1);
            } while(self::is_running($name));
         }

         var_dump(self::is_running($name), $name);

         return self::start($name);
      }

      /**
       * Installes a service from an executable
       *
       * @author Art <a.molcanovas@gmail.com>
       *
       * @param string      $service_name The name of the service
       * @param string      $exe_path     Path to the executable
       * @param null|string $display_name Optionally, a custom display name for the service
       *
       * @return string shell_exec() output
       */
      static function installExe($service_name, $exe_path, $display_name = null) {
         $cmd = 'sc create ' . $service_name . ' binPath= "' . $exe_path . '"';

         if($display_name) {
            $cmd .= ' DisplayName= "' . $display_name . '"';
         }

         return shell_exec($cmd);
      }
   }