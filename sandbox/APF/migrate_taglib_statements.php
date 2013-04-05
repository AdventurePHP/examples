<?php
include(dirname(__FILE__) . '/migrate_base.php');

$files = find('.', '*.html');

$searchAddTaglib = '#<([A-Za-z0-9\-]+):addtaglib([\* |\n|\r\n]+)namespace ?= ?"([A-Za-z0-9:\-]+)"([\* |\n|\r\n]+)class ?= ?"([A-Za-z0-9\-]+)"#';

foreach ($files as $file) {
   $content = file_get_contents($file);

   // replace <*:addtaglib /> calls
   $content = preg_replace_callback($searchAddTaglib, function ($matches) {
      return '<' . $matches[1] . ':addtaglib' . $matches[2] . 'class="APF\\' . str_replace('::', '\\', $matches[3]) . '\\' . $matches[5] . '"';
   }, $content);

   file_put_contents($file, $content);
}