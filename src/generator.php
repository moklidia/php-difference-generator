<?php

namespace Gendiff\generator;

use Funct\Collection;
use Funct\Strings;

function generate($beforeJson, $afterJson)
{
    $before = json_decode($beforeJson, true);
    $after = json_decode($afterJson, true);
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

    return $result;
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
