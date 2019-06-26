<?php

namespace Gendiff\generator;

use Symfony\Component\Yaml\Yaml;
use Funct\Collection;
use function Gendiff\renderer\render;

function generateDiff($file1, $file2)
{
    $before = parseFile($file1);
    $after = parseFile($file2);
    $ast = generateAst($before, $after);
    return render($ast);
}

function generateAst($before, $after)
{
    $keys = Collection\union(array_keys($before), array_keys($after));
    $ast = array_reduce($keys, function ($acc, $key) use ($before, $after) {
            $acc[] = getTypes($key, $before, $after);
        return $acc;
    });
    return $ast;
}

function getTypes($key, $before, $after)
{
    
    if (!array_key_exists($key, $before)) {
        return ['type' => 'added', 'key' => $key, 'value' => $after[$key]];
    }
    if (!array_key_exists($key, $after)) {
        return ['type' => 'deleted', 'key' => $key, 'value' => $before[$key]];
    }
    if (is_array($before[$key]) && is_array($after[$key])) {
        return ['type' => 'parent', 'name' => $key, 'children' => generateAst($before[$key], $after[$key])];
    }
    if ($before[$key] === $after[$key]) {
        return ['type' => 'unchanged', 'key' => $key, 'value' => $before[$key]];
    }
    if ($before[$key] !== $after[$key]) {
        return ['type' => 'changed', 'key' => $key, 'old_value' => $before[$key], 'new_value' => $after[$key]];
    }
}


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
