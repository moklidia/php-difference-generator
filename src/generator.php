<?php

namespace Gendiff\generator;

use function Gendiff\parser\parse;
use function Gendiff\astBuilder\generateAst;
use function Gendiff\pretty\renderPretty;
use function Gendiff\json\renderJson;
use function Gendiff\plain\renderPlain;

function generateDiff($filepath1, $filepath2, $format)
{

    $rawBefore = file_get_contents($filepath1);
    $rawAfter = file_get_contents($filepath2);
    $parsedBefore = parse($rawBefore, pathinfo($filepath1, PATHINFO_EXTENSION));
    $parsedAfter = parse($rawAfter, pathinfo($filepath2, PATHINFO_EXTENSION));
    $ast = generateAst($parsedBefore, $parsedAfter);
    $mapping = [
        'pretty' => function ($ast) {
            return renderPretty($ast);
        },
        'plain' => function ($ast) {
            return renderPlain($ast);
        },
        'json' => function ($ast) {
            return renderJson($ast);
        }
    ];
    return $mapping[$format]($ast);
}
