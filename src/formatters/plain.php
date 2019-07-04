<?php

namespace Gendiff\formatters\plain;

use function Gendiff\utils\boolToDiff;

function renderPlain($ast)
{
    $result = getChanges($ast);
    return implode(PHP_EOL, $result);
}
function getChanges($ast, $ancestry = null)
{
    $result = array_reduce($ast, function ($acc, $node) use ($ancestry) {
        switch ($node['type']) {
            case 'parent':
                $acc[] = getChanges($node['children'], $node['name']);
                break;
            case 'deleted':
                $propertyName = getPropertyName($node, $ancestry);
                $value = getValue($node['value']);
                $acc[] = "Property '{$propertyName}' was removed";
                break;
            case 'added':
                $propertyName = getPropertyName($node, $ancestry);
                $value = getValue($node['value']);
                $acc[] = "Property '{$propertyName}' was added with value: '{$value}'";
                break;
            case 'changed':
                $propertyName = getPropertyName($node, $ancestry);
                $oldValue = getValue($node['oldValue']);
                $newValue = getValue($node['newValue']);
                $acc[] = "Property '{$propertyName}' was changed. From '{$oldValue}' to '{$newValue}'";
                break;
        }
        return $acc;
    });
    return collect($result)->flatten()->all();
}

function getPropertyName($node, $ancestry)
{
    if ($ancestry === null) {
        return "{$node['key']}";
    }
    return "{$ancestry}.{$node['key']}";
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
