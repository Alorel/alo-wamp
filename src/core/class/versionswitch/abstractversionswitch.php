<?php

   namespace VersionSwitch;

   use \Format;
   use \Settings as SET;
   use \IO;
   use Service\Service;

   abstract class AbstractVersionSwitch {

      protected $dependent_dirs = [];

      /**
       * @var string
       */
      protected $ini;

      /**
       * @var string
       */
      protected $dir;

      protected $old_version;

      protected $new_version;

      protected $service;

      function __construct() {
         $this->old_version = SET::$s->{$this->ini};
         $this->trySwitch();
      }

      /**
       * @return AbstractVersionSwitch
       */
      function updateDependencies() {
         $allowed = [DIR_APACHE];

         _echo('Checking dependencies');

         foreach ($this->dependent_dirs as $d) {
            if (file_exists($d) && in_array($d, $allowed)) {
               $scan = scandir($d);
               Format::formatScandir($scan);

               if (!empty($scan)) {
                  $method = $service = false;

                  switch ($d) {
                     case DIR_APACHE:
                        $method = 'updateApache';
                        $service = 'aloapache';
                        break;
                  }

                  if ($method) {
                     foreach ($scan as $version) {
                        call_user_func([$this, $method], $version);
                     }

                     if ($service && Service::exists($service)) {
                        _echo('Restarting service');
                        Service::restart($service);
                     }
                  }
               }
            }
         }

         _echo('Switch complete');

         return $this;
      }

      protected function restartService() {
         if ($this->service) {
            Service::restart($this->service);
         }

         return $this;
      }

      protected function updateApache($version) {
         _echo('Updating Apache ' . $version);
         $file = DIR_APACHE . $version . DIRECTORY_SEPARATOR . 'conf' . DIRECTORY_SEPARATOR . 'httpd.conf';

         if (!file_exists($file)) {
            _echo('Failed to update ' . $version . ': httpd.conf not found');
         } else {
            $contents = file_get_contents($file);
            $contents = str_ireplace('bin' . DIRECTORY_SEPARATOR . 'php' . DIRECTORY_SEPARATOR . $this->old_version, 'bin' . DIRECTORY_SEPARATOR . 'php' . DIRECTORY_SEPARATOR . $this->new_version, $contents);

            if (file_put_contents($file, $contents) !== false) {
               _echo($version . ' updated');
            } else {
               _echo('Failed to edit ' . $version . '\'s httpd.conf');
            }
         }
      }

      /**
       * @return AbstractVersionSwitch
       */
      function trySwitch() {
         if (!file_exists($this->dir)) {
            die('The module is not installed');
         } elseif (!$this->old_version) {
            die('Module installation config entry missing');
         } else {
            $installed_versions = scandir($this->dir);
            Format::formatScandir($installed_versions);

            if (count($installed_versions) < 2) {
               die('You only have one module version installed');
            } else {
               _echo('Your current version is ' . $this->old_version . '. Which version would you like to switch to? Available options are:');

               foreach ($installed_versions as $v) {
                  echo "\t$v" . PHP_EOL;
               }

               $io = IO::readline();

               if (!$io) {
                  return $this->trySwitch();
               } elseif (!in_array($io, $installed_versions)) {
                  _echo('You don\'t have that version installed');

                  return $this->trySwitch();
               } else {
                  SET::$s->{$this->ini} = $this->new_version = $io;
                  SET::$s->save();
                  $this->updateDependencies()->restartService();
               }
            }
         }

         return $this;
      }
   }