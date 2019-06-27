<?php

namespace Gendiff\plain;

use function Gendiff\utils\boolToDiff;

function renderPlain($ast)
{
    $result = getChanges($ast);
    return implode(PHP_EOL, $result);
}
function getChanges($ast, $parent = null)
{
    $result = array_reduce($ast, function ($acc, $node) use ($parent) {
        if ($node['type'] === 'parent') {
            var_dump($node['children']);
            $acc[] = getChanges($node['children'], $node['name']);
        }
        if ($node['type'] === 'deleted') {
            $propertyName = getPropertyName($node, $parent);
            $value = getValue($node['value']);
            $acc[] = "Property '{$propertyName}' was removed";
        }
        if ($node['type'] === 'added') {
            $propertyName = getPropertyName($node, $parent);
            $value = getValue($node['value']);
            $acc[] = "Property '{$propertyName}' was added with value: '{$value}'";
        }
        if ($node['type'] === 'changed') {
            $propertyName = getPropertyName($node, $parent);
            $oldValue = getValue($node['old_value']);
            $newValue = getValue($node['new_value']);
            $acc[] = "Property '{$propertyName}' was changed. From '{$oldValue}' to '{$newValue}'";
        }
        return $acc;
    });
    return collect($result)->flatten()->all();
}

function getPropertyName($node, $parent)
{
    if ($parent === null) {
        return "{$node['key']}";
    }
    return "{$parent}.{$node['key']}";
}

function getValue($value)
{
    if (is_bool($value)) {
        return boolToDiff($value);
    } elseif (is_array($value)) {
        return 'complex value';
    }
    return $value;
}
