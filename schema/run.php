<?php

use Av\Core\Database\DB;

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../core/common.php';

$path = __DIR__ . '/scripts';
$files = scandir($path);

$scripts = [];
foreach ($files as $file) {
    if (in_array($file, ['.', '..'])) {
        continue;
    }
    $data = require $path . '/' . $file;
    $data['name'] = $file;
    $scripts[] = $data;
}

usort($scripts, function ($a, $b) {
    return $a['weight'] >= $b['weight'];
});

foreach ($scripts as $script) {
    foreach ($script['queries'] as $number => $query) {
        try {
            DB::exec($query);
        } catch (\PDOException $ex) {
            print "Failed run #{$number} for {$script['name']}: `{$ex->getMessage()}`.\r\n";
        }
    }
}