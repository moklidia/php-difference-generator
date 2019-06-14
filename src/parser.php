<?php

namespace Gendiff\parser;

use function Gendiff\generator\generate;
use Docopt;

function run()
{
    $doc = <<<DOC
	Generate diff

	Usage:
	  gendiff (-h|--help)
	  gendiff [--format <fmt>] <firstFile> <secondFile>

	Options:
	  -h --help                     Show this screen
	  --format <fmt>                Report format [default: pretty]

	DOC;

    $args = Docopt::handle($doc);
    $filePath1 = $args['<firstFile>'];
    $filePath2 = $args['<secondFile>'];
        
    return generate($filePath1, $filePath2);
}
