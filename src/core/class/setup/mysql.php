<?php

   namespace Setup;

   use Format;
   use Service;
   use Settings as SET;

   /**
    * Sets up MySQL
    *
    * @author Art <a.molcanovas@gmail.com>
    */
   class MySQL extends AbstractBinSetup {

      /**
       * BinChecker instance
       *
       * @var \BinChecker\MySQL
       */
      protected $binchecker;

      /**
       * Constructor
       *
       * @author Art <a.molcanovas@gmail.com>
       */
      function __construct() {
         $this->dest       = DIR_TMP . 'mysql.zip';
         $this->dest_unzip = DIR_TMP . 'mysql' . DIRECTORY_SEPARATOR;

         $this->binchecker = new \BinChecker\MySQL();
         $this->links      = $this->binchecker->getLinks();

         $this
            ->promptDownload()
            ->unzip()
            ->copy()
            ->editMyIni()
            ->installService();
      }

      /**
       * Installs the service
       *
       * @author Art <a.molcanovas@gmail.com>
       * @return MySQL
       */
      protected function installService() {
         if(Service::exists('alomysql')) {
            _echo('Removing previous AloWAMP MySQL service');
            _echo(Service::delete('alomysql'));
         }

         _echo('Installing MySQL service');
         _echo(Service::installExe('alomysql',
                                   DIR_MYSQL .
                                   $this->version .
                                   DIRECTORY_SEPARATOR .
                                   'bin' .
                                   DIRECTORY_SEPARATOR .
                                   'mysqld.exe alomysql',
                                   'AloWAMP MySQL ' . $this->version));

         return $this;
      }

      /**
       * Edits my.ini
       *
       * @author Art <a.molcanovas@gmail.com>
       * @return MySQL
       */
      protected function editMyIni() {
         $dest = DIR_MYSQL . $this->version . DIRECTORY_SEPARATOR . 'my.ini';
         $dir  = DIR_MYSQL . $this->version;

         $contents = str_replace([
                                    '{$basedir}',
                                    '{$log-error}',
                                    '{$datadir}',
                                    '{$lc-messages-dir}'
                                 ],
                                 [
                                    '"' . $dir . '"',
                                    '"' . DIR_LOGS . 'mysql' . DIRECTORY_SEPARATOR . 'mysql.log"',
                                    '"' . $dir . DIRECTORY_SEPARATOR . 'data"',
                                    '"' . $dir . DIRECTORY_SEPARATOR . 'share"'
                                 ],
                                 file_get_contents(DIR_CORE . 'file_placeholders' . DIRECTORY_SEPARATOR . 'my.ini'));
         if(file_put_contents($dest, $contents) !== false) {

         }

         return $this;
      }

      /**
       * Unzips downloaded contents
       *
       * @author Art <a.molcanovas@gmail.com>
       * @return MySQL
       */
      protected function unzip() {
         _echo('It\'s a fairly large file so this next step might take a while..');

         return parent::unzip();
      }

      /**
       * Copies unzipped contents
       *
       * @author Art <a.molcanovas@gmail.com>
       * @return MySQL
       */
      protected function copy() {
         $scan = scandir($this->dest_unzip);
         Format::formatScandir($scan);
         $dir = null;

         foreach($scan as $s) {
            if(is_dir($this->dest_unzip . $s)) {
               $dir = $this->dest_unzip . $s;
               break;
            }
         }

         if(!$dir) {
            die('Could not find the MySQL source directory in the unzipped files. Aborting.');
         } else {
            _echo('Copying downloaded contents. It\'s usually over 1GB so this might take a while...');
            $source                     = $dir;
            $this->unzipped_destination = DIR_MYSQL . $this->version;

            if(!file_exists($this->unzipped_destination . DIRECTORY_SEPARATOR)) {
               mkdir($this->unzipped_destination . DIRECTORY_SEPARATOR, 777, true);
            }

            shell_exec('xcopy /s /e "' . $source . '" "' . $this->unzipped_destination . '"');
            $this->unzipped_destination .= DIRECTORY_SEPARATOR;

            if(file_exists($this->unzipped_destination . 'bin')) {
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
       * Updates settings.ini
       *
       * @author Art <a.molcanovas@gmail.com>
       * @return MySQL
       */
      protected function updateSettings() {
         SET::$s->mysql_version = $this->version;
         Set::$s->save();

         return $this;
      }
   }