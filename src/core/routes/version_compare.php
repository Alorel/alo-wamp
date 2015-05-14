<?php

   _echo('Checking remote version...');

   $remote_version = trim(file_get_contents('https://raw.githubusercontent.com/Alorel/AloWAMP/master/src/VERSION'));
   $local_version = trim(file_get_contents(DIR_INDEX . 'VERSION'));

   _echo('Local version: ' . $local_version);
   _echo('Remote version: ' . $remote_version);

   if (version_compare($local_version, $remote_version, '>')) {
      $loop = true;
      do {
         $io = trim(IO::readline('Would you like to download the update? [Y\N]'));

         switch ($io) {
            case '':
               continue;
            case 'y':
               shell_exec('start ' . HOMEPAGE);
               $loop = false;
               break;
            default:
               $loop = false;
         }
      } while ($loop);
   } else {
      _echo('You have the newest version');
   }