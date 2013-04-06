<?php
include(dirname(__FILE__) . '/migrate_base.php');

$files = find('.', '*.html');

$searchAddTaglib = '#<([A-Za-z0-9\-]+):addtaglib([\*| |\n|\r\n]+)namespace ?= ?"([A-Za-z0-9:\-]+)"([\*| |\n|\r\n]+)class ?= ?"([A-Za-z0-9\-]+)"#';

$searchSingleNamespace = '#<([A-Za-z0-9\-]+):importdesign([\*| |\n|\r\n]+)namespace="([A-Za-z0-9:\-]+)"#';

$searchGetStringNamespace = '#<([A-Za-z0-9\-]+):getstring([\*| |\n|\r\n]+)namespace="([A-Za-z0-9:\-]+)"#';

$searchAppendNodeNamespace = '#<([A-Za-z0-9\-]+):appendnode([\*| |\n|\r\n]+)namespace="([A-Za-z0-9:\-]+)"#';

foreach ($files as $file) {
   $content = file_get_contents($file);

   // replace <*:addtaglib /> calls
   $content = preg_replace_callback($searchAddTaglib, function ($matches) {
      return '<' . $matches[1] . ':addtaglib' . $matches[2] . 'class="APF\\' . str_replace('::', '\\', $matches[3]) . '\\' . $matches[5] . '"';
   }, $content);

   // replace <*:importdesign /> calls
   $content = preg_replace_callback($searchSingleNamespace, function ($matches) {
      return '<' . $matches[1] . ':importdesign' . $matches[2] . 'namespace="APF\\' . str_replace('::', '\\', $matches[3]) . '"';
   }, $content);

   // replace <*:getstring /> calls
   $content = preg_replace_callback($searchGetStringNamespace, function ($matches) {
      return '<' . $matches[1] . ':getstring' . $matches[2] . 'namespace="APF\\' . str_replace('::', '\\', $matches[3]) . '"';
   }, $content);

   // replace <*:appendnode /> calls
   $content = preg_replace_callback($searchAppendNodeNamespace, function ($matches) {
      return '<' . $matches[1] . ':appendnode' . $matches[2] . 'namespace="APF\\' . str_replace('::', '\\', $matches[3]) . '"';
   }, $content);

   file_put_contents($file, $content);
}