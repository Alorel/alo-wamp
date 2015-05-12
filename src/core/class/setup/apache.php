<?php

   namespace Setup;

   use \Format;
   use \Settings as SET;
   use \Service;

   class Apache extends AbstractBinSetup {

      /**
       * @var \BinChecker\Apache
       */
      protected $binchecker;

      function __construct() {
         $this->dest = DIR_TMP . 'httpd.zip';
         $this->dest_unzip = DIR_TMP . 'httpd' . DIRECTORY_SEPARATOR;

         $this->binchecker = new \BinChecker\Apache();
         $this->links = $this->binchecker->getLinks();

         $this
            ->promptDownload()
            ->unzip()
            ->copy()
            ->editHTTPD()
            ->installService();
      }

      /**
       * @return Apache
       */
      protected function installService() {
         if (Service::exists('aloapache')) {
            _echo('Removing previous AloWAMP apache service');
            Service::delete('aloapache');
         }

         _echo('Installing apache service');
         Service::installExe('aloapache', DIR_APACHE . $this->version . DIRECTORY_SEPARATOR . 'bin' . DIRECTORY_SEPARATOR . 'httpd.exe -k runservice', 'AloWAMP Apache ' . $this->version);

         return $this;
      }

      /**
       * @return Apache
       */
      protected function promptDownload() {
         return parent::promptDownload();
      }

      /**
       * @return Apache
       */
      protected function unzip() {
         return parent::unzip();
      }

      protected function checkWebDir() {
         if (!SET::$s->web_dir) {
            $new_dir = \IO::readline('Your default website name was not found - please enter a name (defaults to my-default-website if left empty)');

            if (!$new_dir) {
               $new_dir = 'my-default-website';
            }

            SET::$s->web_dir = $new_dir;
            SET::$s->save();
         }

         if (!file_exists(DIR_WWW . SET::$s->web_dir . DIRECTORY_SEPARATOR)) {
            mkdir(DIR_WWW . SET::$s->web_dir . DIRECTORY_SEPARATOR, 777, true);
         }
      }

      /**
       * @return Apache
       */
      protected function editHTTPD() {
         $this->checkWebDir();
         $apache_dir = DIR_APACHE . $this->version . DIRECTORY_SEPARATOR;
         $httpd_conf = $apache_dir . 'conf' . DIRECTORY_SEPARATOR . 'httpd.conf';

         if (file_exists($httpd_conf)) {
            $contents = file_get_contents($httpd_conf);

            if (!$contents) {
               die('Failed to open httpd.conf. Aborting setup.');
            } else {
               _echo('Editing httpd.conf');

               $php_dir = DIR_PHP . SET::$s->php_version;

               $php5_module_loc = '"' . $php_dir . DIRECTORY_SEPARATOR . 'php5apache2_4.dll"';
               $php5_module_replace = 'PHPIniDir "' . $php_dir . '"' . PHP_EOL
                  . 'LoadModule php5_module ' . $php5_module_loc . PHP_EOL
                  . 'LoadModule access_compat_module modules/mod_access_compat.so';

               $htdocs = DIR_WWW . SET::$s->web_dir;
               $log_dir = DIR_LOGS . 'apache' . DIRECTORY_SEPARATOR;

               $contents = str_ireplace([
                  'LoadModule access_compat_module modules/mod_access_compat.so',
                  'ServerRoot "c:/Apache24"',
                  'Listen 80',
                  '#ServerName www.example.com:80',
                  '"c:/Apache24/htdocs"',
                  'DirectoryIndex index.html',
                  '"logs/error.log"',
                  '"logs/access.log"',
                  'AddType application/x-gzip .gz .tgz'
               ], [
                  $php5_module_replace,
                  'ServerRoot "' . rtrim($apache_dir, DIRECTORY_SEPARATOR) . '"',
                  'Listen 80' . PHP_EOL . 'Listen 443',
                  'ServerName localhost:80',
                  '"' . $htdocs . '"',
                  'DirectoryIndex index.php index.php3 index.html index.htm',
                  '"' . $log_dir . 'error.log"',
                  '"' . $log_dir . 'access.log"',
                  'AddType application/x-gzip .gz .tgz' . PHP_EOL . "\tAddType application/x-httpd-php .php" . PHP_EOL . "\tAddType application/x-httpd-php .php3"
               ], $contents);

               if (file_put_contents($httpd_conf, $contents) !== false) {
                  _echo('httpd.conf edited');
               } else {
                  die('Failed to edit httpd.conf. Aborting setup.');
               }
            }
         } else {
            die('Could not find httpd.conf. Aborting.');
         }

         return $this;
      }

      /**
       * @return Apache
       */
      protected function copy() {
         $scan = scandir($this->dest_unzip);
         Format::formatScandir($scan);
         $dir = null;

         foreach ($scan as $s) {
            if (is_dir($this->dest_unzip . $s)) {
               $dir = $this->dest_unzip . $s;
               break;
            }
         }

         if (!$dir) {
            die('Could not find the apache source directory in the unzipped files. Aborting.');
         } else {
            _echo('Copying downloaded contents...');
            $source = $dir;
            $this->unzipped_destination = DIR_APACHE . $this->version;

            if (!file_exists($this->unzipped_destination . DIRECTORY_SEPARATOR)) {
               mkdir($this->unzipped_destination . DIRECTORY_SEPARATOR, 777, true);
            }

            shell_exec('xcopy /s /e "' . $source . '" "' . $this->unzipped_destination . '"');
            $this->unzipped_destination .= DIRECTORY_SEPARATOR;

            if (file_exists($this->unzipped_destination . 'bin')) {
               _echo('Copy successful!');
               $this->updateSettings();
            } else {
               die('Failed to copy. Terminating setup.');
            }

         }

         return $this;
      }

      /**
       * @return Apache
       */
      protected function updateSettings() {
         SET::$s->apache_version = $this->version;
         SET::$s->save();

         return $this;
      }
   }