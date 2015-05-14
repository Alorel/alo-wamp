<?php

   namespace Setup;

   use \Settings as SET;
   use Service\Redis AS Service;

   class Redis extends AbstractBinSetup {

      /**
       * @var \BinChecker\Redis
       */
      protected $binchecker;

      function __construct() {
         $this->dest = DIR_TMP . 'redis.zip';
         $this->dest_unzip = DIR_TMP . 'redis' . DIRECTORY_SEPARATOR;

         $this->binchecker = new \BinChecker\Redis();
         $this->links = $this->binchecker->getLinks();

         $this
            ->promptDownload()
            ->unzip()
            ->copy()
            ->editConf()
            ->installService();
      }

      /**
       * @return Redis
       */
      protected function installService() {
         if (Service::exists('aloredis')) {
            _echo('Removing previous AloWAMP Redis service');
            Service::delete('aloredis');
         }

         _echo('Installing Redis service');
         Service::installExe('aloredis', DIR_REDIS . $this->version . DIRECTORY_SEPARATOR . 'redis-server.exe', 'aloredis');

         return $this;
      }

      /**
       * @return Redis
       */
      protected function editConf() {
         $file = DIR_REDIS . $this->version . DIRECTORY_SEPARATOR . 'redis.windows.conf';

         if (!file_exists($file)) {
            die('Redis configuration file not found. Aborting.');
         } else {
            _echo('Editing Redis configuration file');
            $contents = file_get_contents($file);

            $contents = str_ireplace([
               '# bind 127.0.0.1',
               'tcp-keepalive 0',
               'logfile ""'
            ], [
               'bind 127.0.0.1',
               'tcp-keepalive 60',
               'logfile "' . DIR_LOGS . 'redis' . DIRECTORY_SEPARATOR . 'redis.log"'
            ], $contents);

            if (file_put_contents($file, $contents) !== false) {
               _echo('Redis config file edited');
            } else {
               die('Failed to edit Redis config file. Abording.');
            }
         }

         return $this;
      }

      /**
       * @return Redis
       */
      protected function copy() {
         _echo('Copying unzipped contents..');

         $source = rtrim($this->dest_unzip, DIRECTORY_SEPARATOR);
         $this->unzipped_destination = DIR_REDIS . $this->version;

         if (!file_exists($this->unzipped_destination)) {
            mkdir($this->unzipped_destination . DIRECTORY_SEPARATOR, 777, true);
         }

         shell_exec('xcopy /s /e "' . $source . '" "' . $this->unzipped_destination . '"');

         $this->unzipped_destination .= DIRECTORY_SEPARATOR;

         if (file_exists($this->unzipped_destination . 'redis-server.exe')) {
            _echo('Copy successful!');
            $this->updateSettings();
            $this->cleanup();
         } else {
            die('Failed to copy. Terminating setup.');
         }

         return $this;
      }

      /**
       * @return Redis
       */
      protected function updateSettings() {
         SET::$s->redis_version = $this->version;
         SET::$s->save();

         return $this;
      }
   }