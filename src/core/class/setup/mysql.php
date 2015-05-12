<?php

   namespace Setup;

   use \Format;
   use \Service;

   class MySQL extends AbstractBinSetup {

      /**
       * @var \BinChecker\MySQL
       */
      protected $binchecker;

      function __construct() {
         $this->dest = DIR_TMP . 'mysql.zip';
         $this->dest_unzip = DIR_TMP . 'mysql' . DIRECTORY_SEPARATOR;

         $this->binchecker = new \BinChecker\MySQL();
         $this->links = $this->binchecker->getLinks();

         $this
            ->promptDownload()
            ->unzip()
            ->copy()
            ->editMyIni()
            ->installService();
      }

      /**
       * @return MySQL
       */
      protected function installService() {
         if (Service::exists('alomysql')) {
            _echo('Removing previous AloWAMP MySQL service');
            Service::delete('alomysql');
         }

         _echo('Installing MySQL service');
         Service::installExe('alomysql', DIR_MYSQL . $this->version . DIRECTORY_SEPARATOR . 'bin' . DIRECTORY_SEPARATOR . 'mysqld.exe alomysql', 'AloWAMP MySQL ' . $this->version);

         return $this;
      }

      /**
       * @return MySQL
       */
      protected function editMyIni() {
         $dest = DIR_MYSQL . $this->version . DIRECTORY_SEPARATOR . 'my.ini';
         $dir = DIR_MYSQL . $this->version;

         $contents = str_replace([
            '{$basedir}',
            '{$log-error}',
            '{$datadir}',
            '{$lc-messages-dir}'
         ], [
            '"' . $dir . '"',
            '"' . DIR_LOGS . 'mysql' . DIRECTORY_SEPARATOR . 'mysql.log"',
            '"' . $dir . DIRECTORY_SEPARATOR . 'data"',
            '"' . $dir . DIRECTORY_SEPARATOR . 'share"'
         ], file_get_contents(DIR_CORE . 'file_placeholders' . DIRECTORY_SEPARATOR . 'my.ini'));
         if (file_put_contents($dest, $contents) !== false) {

         }

         return $this;
      }

      /**
       * @return MySQL
       */
      protected function promptDownload() {
         return parent::promptDownload();
      }

      /**
       * @return MySQL
       */
      protected function unzip() {
         _echo('It\'s a fairly large file so this next step might take a while..');

         return parent::unzip();
      }

      /**
       * @return MySQL
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
            die('Could not find the MySQL source directory in the unzipped files. Aborting.');
         } else {
            _echo('Copying downloaded contents. It\'s usually over 1GB so this might take a while...');
            $source = $dir;
            $this->unzipped_destination = DIR_MYSQL . $this->version;

            if (!file_exists($this->unzipped_destination . DIRECTORY_SEPARATOR)) {
               mkdir($this->unzipped_destination . DIRECTORY_SEPARATOR, 777, true);
            }

            shell_exec('xcopy /s /e "' . $source . '" "' . $this->unzipped_destination . '"');
            $this->unzipped_destination .= DIRECTORY_SEPARATOR;

            if (file_exists($this->unzipped_destination . 'bin')) {
               _echo('Copy successful!');
               $this->cleanup();
               $this->updateSettings();
            } else {
               die('Failed to copy. Terminating setup.');
            }

         }

         return $this;
      }

      /**
       * @return MySQL
       */
      protected function updateSettings() {
         return $this;
      }
   }