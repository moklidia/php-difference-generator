<?php

namespace Gendiff\parser;

use Symfony\Component\Yaml\Yaml;

function parse($content, $dataType)
{
    $mapping = [
        'json' => function ($content) {
            return json_decode($content, true);
        },
        'yaml' => function ($content) {
            return Yaml::parse($content);
        }
    ];
    return $mapping[$dataType] ($content);
}
