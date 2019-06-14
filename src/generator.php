<?php

namespace Gendiff\generator;

use Symfony\Component\Yaml\Yaml;
use Funct\Collection;
use Funct\Strings;

function generate($file1, $file2)
{
    $before = (array)parseFile($file1);
    $after = (array)parseFile($file2);
    $keys = Collection\union(array_keys($before), array_keys($after));
    $changes = array_reduce($keys, function ($acc, $key) use ($before, $after) {
        if ((array_key_exists($key, $before)) && (array_key_exists($key, $after))) {
            if ($before[$key] === $after[$key]) {
                $acc["    {$key}"] = $after[$key];
            } else {
                $acc["  + {$key}"] = $after[$key];
                $acc["  - {$key}"] = $before[$key];
            }
        } elseif ((array_key_exists($key, $before)) && (!array_key_exists($key, $after))) {
            $acc["  - {$key}"] = $before[$key];
        } else {
            $acc["  + {$key}"] = $after[$key];
        }
        return $acc;
    });
    $changesToString = collect($changes)
              ->map(function ($item, $key) {
                $itemToString = toString($item);
                return "{$key}: {$itemToString}";
              })->implode(PHP_EOL);
    $result = "{\n{$changesToString}\n}";
    echo $result;
    return $result;
}

function parseFile($file)
{

    $content = file_get_contents($file);
    $extension = pathinfo($file, PATHINFO_EXTENSION);
    if ($extension === 'json') {
        return json_decode($content);
    } elseif ($extension === 'yaml' || $extension = 'yml') {
        $parsed = Yaml::parseFile($file, Yaml::PARSE_OBJECT_FOR_MAP);
        return $parsed;
    }
    exit('Unknown file format');
}

function ToString($item)
{
    if ($item === true) {
        return 'true';
    } elseif ($item === false) {
        return 'false';
    } elseif ($item === null) {
        return 'null';
    } else {
        return "{$item}";
    }
}
