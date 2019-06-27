<?php

namespace Gendiff\parser;

use Symfony\Component\Yaml\Yaml;

function parseFile($file)
{

    $content = file_get_contents($file);
    $extension = pathinfo($file, PATHINFO_EXTENSION);
    if ($extension === 'json') {
        return json_decode($content, true);
    } elseif ($extension === 'yaml' || $extension = 'yml') {
        $parsed = Yaml::parseFile($file);
        return $parsed;
    }
    exit('Unknown file format');
}
