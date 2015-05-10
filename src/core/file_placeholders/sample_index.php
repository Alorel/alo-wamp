<?php

   echo 'Your AloWAMP server is up and running. The error below is just to make sure logging is set up correctly - you should see an entry in logs/php/php_error.log';

   trigger_error('Raaargh!', E_USER_ERROR);