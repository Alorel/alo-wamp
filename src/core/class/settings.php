<?php

   /**
    * settings.ini handler
    *
    * @author Art <a.molcanovas@gmail.com>
    */
   class Settings {

      /**
       * Static reference to $this
       *
       * @var Settings
       */
      public static $s;
      /**
       * Settings array
       *
       * @var array
       */
      protected $settings;
      /**
       * Whether a change was made and an autosave should be performed on destruct
       *
       * @var bool
       */
      protected $change_was_made;

      /**
       * Instantiates the class
       *
       * @author Art <a.molcanovas@gmail.com>
       */
      function __construct() {
         self::$s               = &$this;
         $this->change_was_made = false;
         $this->load();
      }

      /**
       * Loads the settings
       *
       * @author Art <a.molcanovas@gmail.com>
       */
      function load() {
         $file = DIR_CORE . 'settings.ini';

         if(!file_exists($file)) {
            file_put_contents($file, '');
            $this->settings = [];
         } else {
            $contents       = file_get_contents($file);
            $this->settings = $contents ? Format::ini_to_array($contents, false) : [];
         }
      }

      /**
       * Closing operations
       *
       * @author Art <a.molcanovas@gmail.com>
       */
      function __destruct() {
         if($this->change_was_made) {
            $this->save();
         }
      }

      /**
       * Saves the settings array
       *
       * @author Art <a.molcanovas@gmail.com>
       */
      function save() {
         $file = DIR_CORE . 'settings.ini';

         if(file_exists($file)) {
            unlink($file);
         }

         $put = '';

         foreach($this->settings as $k => $v) {
            $put .= "$k=$v" . PHP_EOL;
         }

         file_put_contents($file, $put);
      }

      /**
       * Gets a config item
       *
       * @param string $v Ttem key
       *
       * @return mixed
       */
      function __get($v) {
         return get($this->settings[$v]);
      }

      /**
       * Sets a config item
       *
       * @author Art <a.molcanovas@gmail.com>
       *
       * @param string $k Item key
       * @param string $v Item value
       */
      function __set($k, $v) {
         $this->change_was_made = true;
         $this->settings[$k]    = $v;
      }

      /**
       * Gets all the settings
       *
       * @author Art <a.molcanovas@gmail.com>
       * @return array
       */
      function get() {
         return $this->settings;
      }
   }