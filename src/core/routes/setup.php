<?php

   $setup = new Setup();

   echo 'Hi! I will guide you through the setup.' . PHP_EOL . 'First, let\'s check if you have some of the core directories present.';
   IO::echo_lines(2);

   $setup->checkTMP()
      ->checkMemcache();