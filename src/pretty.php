<?php

namespace Gendiff\pretty;

use function Gendiff\utils\boolToDiff;


function renderPretty($ast)
{
    $result = getChanges($ast);
    return "{\n{$result}\n}";
}
function getChanges($ast, $depth = 0)
{
    $indent = str_repeat('    ', $depth);
    $changes = array_reduce($ast, function ($acc, $node) use ($depth, $indent) {
        if ($node['type'] === 'parent') {
            $children = getChanges($node['children'], $depth + 1);
            $acc[] = "{$indent}    {$node['name']}: {\n{$children}\n    {$indent}}";
        }
        if ($node['type'] === 'added') {
            $value = valueToDiff($node['value'], $depth);
            $acc[] = "{$indent}  + {$node['key']}: {$value}";
        }
        if ($node['type'] === 'deleted') {
            $value = valueToDiff($node['value'], $depth);
            $acc[] = "{$indent}  - {$node['key']}: {$value}";
        }
        if ($node['type'] === 'unchanged') {
            $value = valueToDiff($node['value'], $depth);
            $acc[] = "{$indent}    {$node['key']}: {$value}";
        }
        if ($node['type'] === 'changed') {
            $newValue = valueToDiff($node['new_value'], $depth);
            $oldValue = valueToDiff($node['old_value'], $depth);
            $acc[] = "{$indent}  + {$node['key']}: {$newValue}\n{$indent}  - {$node['key']}: {$oldValue}";
        }
        
        return $acc;
    });
    $result = implode(PHP_EOL, $changes);
    return $result;
}

function valueToDiff($value, $depth)
{
    if (is_bool($value)) {
        return boolToDiff($value);
    }
    if (is_array($value)) {
        return arrayToDiff($value, $depth);
    }
    return $value;
}

function arrayToDiff($items, $depth)
{
    $indent = str_repeat('    ', $depth + 1);
    $keys = array_keys($items);
    $values = array_reduce($keys, function ($acc, $key) use ($items, $indent) {
        $acc[] = "{$indent}    {$key}: {$items[$key]}";
        return $acc;
    });
    $result = implode(PHP_EOL, $values);
    return "{\n{$result}\n{$indent}}";
}
