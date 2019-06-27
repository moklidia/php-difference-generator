<?php

namespace Gendiff\utils;

function boolToDiff($value)
{
    if ($value === true) {
        return 'true';
    }
    return 'false';
}
