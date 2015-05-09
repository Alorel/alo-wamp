<?php

   class Settings {

      /**
       * Settings array
       *
       * @var array
       */
      protected $settings;

      /**
       * @var Settings
       */
      public static $s;

      /**
       * @var bool
       */
      protected $change_was_made;

      function __construct() {
         self::$s = &$this;
         $this->change_was_made = false;
         $this->load();
      }

      function __destruct() {
         if ($this->change_was_made) {
            $this->save();
         }
      }

      function __get($v) {
         return get($this->settings[$v]);
      }

      function get() {
         return $this->settings;
      }

      function __set($k, $v) {
         $this->change_was_made = true;
         $this->settings[$k] = $v;
      }

      /**
       * Saves the settings array
       *
       * @author Art <a.molcanovas@gmail.com>
       */
      function save() {
         $file = DIR_CORE . 'settings.ini';

         if (file_exists($file)) {
            unlink($file);
         }

         $put = '';

         foreach ($this->settings as $k => $v) {
            $put .= "$k=$v" . PHP_EOL;
         }

         file_put_contents($file, $put);
      }

      /**
       * Loads the settings
       *
       * @author Art <a.molcanovas@gmail.com>
       */
      function load() {
         $file = DIR_CORE . 'settings.ini';

         if (!file_exists($file)) {
            file_put_contents($file, '');
            $this->settings = [];
         } else {
            $contents = file_get_contents($file);
            $this->settings = $contents ? Format::ini_to_array($contents, false) : [];
         }
      }
   }