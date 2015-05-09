<?php

   class FormatTest extends PHPUnit_Framework_TestCase {

      function testIni() {
         $a = [
            'test_category' => [
               'el_one' => 'val_one',
               'el_two' => 'val_two'
            ],
            'foo_cat'       => [
               'foo_key' => 'foo_val'
            ]
         ];

         $inified = Format::array_to_ini($a);
         $array = Format::ini_to_array($inified, false);

         $this->assertEquals($a, $array);
      }
   }
 