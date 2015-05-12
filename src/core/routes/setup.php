<?php

   $setup = new Setup();

   _('Hi! I will guide you through the setup.' . PHP_EOL . 'First, let\'s check if you have some of the core directories present.');
   IO::echo_lines(2);

   $setup
      ->checkDateTimezone()
      ->checkDir(DIR_TMP, 'tmp folder')
      ->checkDir(DIR_BIN, 'binaries folder')
      ->checkDir(DIR_LOGS . 'php' . DIRECTORY_SEPARATOR, 'PHP log folder')
      ->checkDir(DIR_LOGS . 'apache' . DIRECTORY_SEPARATOR, 'Apache log folder')
      ->checkDir(DIR_LOGS . 'mysql' . DIRECTORY_SEPARATOR, 'MySQL log folder')
      ->checkWWW()
      ->checkPHP()
      ->checkApache()
      ->checkMySQL()
      ->checkMemcache();