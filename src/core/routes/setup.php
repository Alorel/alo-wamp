<?php

   $setup = new Setup();

   _('Hi! I will guide you through the setup.' . PHP_EOL . 'First, let\'s check if you have some of the core directories present.');
   IO::echo_lines(2);

   $setup
      ->checkDateTimezone()
      ->checkDir(DIR_TMP, 'tmp folder')
      ->checkDir(DIR_BIN, 'binaries folder')
      ->checkWWW()
      ->checkMemcache()
      ->checkPHP()
      ->checkApache();