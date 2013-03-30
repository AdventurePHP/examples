<?php
include('./migrate_base.php');

$files = find('config', '*serviceobjects.ini');

$search = '#servicetype ?= ?"([A-Z]+)"
namespace ?= ?"([A-Za-z0-9:]+)"
class ?= ?"([A-Za-z0-9\-]+)"#m';

$searchReference = '#init.([A-Za-z\-_]+).namespace ?= ?"([A-Za-z0-9:]+)"#';

foreach ($files as $file) {
   $content = file_get_contents($file);

   // replace service implementation definitions
   $content = preg_replace_callback($search, function ($matches) {
      return 'servicetype = "' . $matches[1] . '"
class = "APF\\' . str_replace('::', '\\', $matches[2]) . '\\' . $matches[3] . '"';
   }, $content);

   // replace DI wiring definitions
   $content = preg_replace_callback($searchReference, function ($matches) {
      return 'init.' . $matches[1] . '.namespace = "APF\\' . str_replace('::', '\\', $matches[2]) . '"';
   }, $content);

   file_put_contents($file, $content);
}