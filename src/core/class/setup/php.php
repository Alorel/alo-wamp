<?php

   namespace Setup;

   use \Settings as SET;

   class PHP extends AbstractBinSetup {

      /**
       * @var \BinChecker\PHP
       */
      protected $binchecker;

      function __construct() {
         $this->dest = DIR_TMP . 'php.zip';
         $this->dest_unzip = DIR_TMP . 'php' . DIRECTORY_SEPARATOR;

         $this->binchecker = new \BinChecker\PHP();
         $this->links = $this->binchecker->getLinks();

         $this
            ->promptDownload()
            ->unzip()
            ->copy()
            ->renameIni()
            ->editIni();
      }

      protected function editIni() {
         $timezone = SET::$s->php_date_timezone;
         $ini = $this->unzipped_destination . 'php.ini';

         if (!$timezone) {
            $timezone = 'Europe/London';
            _echo('Your timezone setting wasn\'t found. Setting it to Europe/London.');
            SET::$s->php_date_timezone = $timezone;
            SET::$s->save();
         }

         $contents = file_get_contents($ini);

         $err_log_dir = '"' . str_replace(DIRECTORY_SEPARATOR, '/', DIR_LOGS) . 'php/php_errors.log"';

         if ($contents) {
            $contents = str_ireplace([
               ';date.timezone =',
               '; extension_dir = "ext"',
               ';error_log = php_errors.log'
            ], [
               'date.timezone = ' . $timezone,
               'extension_dir = "' . $this->unzipped_destination . 'ext"',
               'error_log = ' . $err_log_dir . ''
            ], $contents);

            if (file_put_contents($ini, $contents) !== false) {
               _echo('php.ini edited');
            } else {
               $msg = 'Failed to edit php.ini. You will have to set the following yourself:' . PHP_EOL
                  . "\t Find ';date.timezone =' and change it to 'date.timezone = ' . $timezone'" . PHP_EOL
                  . "\t Find '; extension_dir = \"ext\"' and change it to 'extension_dir = \"ext\"'" . PHP_EOL
                  . "\t Find ';error_log = php_errors.log' and change it to 'error_log = $err_log_dir'";
               _echo($msg . PHP_EOL . 'Press ENTER to continue');
               \IO::readline();
            }
         } else {
            _echo('Failed to open php.ini for editing. You will have to set the timezone yourself.');
         }

         return $this;
      }

      /**
       * @return PHP
       */
      protected function renameIni() {
         if (!file_exists($this->unzipped_destination . 'php.ini')) {
            $file = null;
            if (file_exists($this->unzipped_destination . 'php.ini-development')) {
               $file = $this->unzipped_destination . 'php.ini-development';
            } elseif (file_exists($this->unzipped_destination . 'php.ini-production')) {
               $file = $this->unzipped_destination . 'php.ini-production';
            } else {
               die('Could not find sample php.ini. Aborting.');
            }

            copy($file, $this->unzipped_destination . 'php.ini');

            if (!file_exists($this->unzipped_destination . 'php.ini')) {
               die('Failed to copy sample php.ini. Aborting.');
            } else {
               _echo('Sample php.ini copied');
            }
         } else {
            _echo('php.ini found');
         }

         return $this;
      }

      /**
       * @return PHP
       */
      protected function copy() {
         _echo('Copying unzipped contents..');

         $source = rtrim($this->dest_unzip, DIRECTORY_SEPARATOR);
         $this->unzipped_destination = DIR_PHP . $this->version;

         if (!file_exists($this->unzipped_destination)) {
            mkdir($this->unzipped_destination . DIRECTORY_SEPARATOR, 777, true);
         }

         shell_exec('xcopy /s /e "' . $source . '" "' . $this->unzipped_destination . '"');

         $this->unzipped_destination .= DIRECTORY_SEPARATOR;

         if (file_exists($this->unzipped_destination . 'php.ini-development') || file_exists($this->unzipped_destination . 'php.ini')) {
            _echo('Copy successful!');
            $this->updateSettings();
         } else {
            die('Failed to copy. Terminating setup.');
         }

         return $this;
      }

      /**
       * @return PHP
       */
      protected function updateSettings() {
         SET::$s->php_version = $this->version;
         SET::$s->save();

         return $this;
      }
   }