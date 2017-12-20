<?php

use Sami\Sami;
use Sami\Version\GitVersionCollection;
use Symfony\Component\Finder\Finder;

$iterator = Finder::create()
    ->files()
    ->name('*.php')
    ->exclude('Test')
    ->in($dir = __DIR__.'/src')
;

// generate documentation for all v2.0.* tags, the 2.0 branch, and the master one
$versions = GitVersionCollection::create($dir)
    ->addFromTags('v1.2.4')
    ->add('master', 'Current Release')
;

$sami = new Sami($iterator, array(
    'versions'             => $versions,
    'title'                => 'CFX Public Models',
    'build_dir'            => __DIR__.'/docs/build/%version%',
    'cache_dir'            => __DIR__.'/docs/cache/%version%',
    'default_opened_level' => 2,
));

return $sami;

