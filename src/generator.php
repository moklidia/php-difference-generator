<?php

namespace Gendiff\generator;

use function Gendiff\parser\parseFile;
use function Gendiff\astBuilder\generateAst;
use function Gendiff\pretty\renderPretty;
use function Gendif\json\renderJson;
use function Gendiff\plain\renderPlain;

function generateDiff($file1, $file2, $format)
{
    $before = parseFile($file1);
    $after = parseFile($file2);
    $ast = generateAst($before, $after);
    if ($format === 'pretty') {
        return renderPretty($ast);
    }
    if ($format === 'plain') {
        return renderPlain($ast);
    }
    if ($format === 'json') {
        return renderJson($ast);
    }
}
