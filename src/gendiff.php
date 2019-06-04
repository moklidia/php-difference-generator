<?php

namespace Gendiff\gendiff;

function run()
{
    require('vendor/docopt/docopt/src/docopt.php');
    
    $doc = <<<DOC
	Generate diff

	Usage:
	  gendiff (-h|--help)
	  gendiff [--format <fmt>] <firstFile> <secondFile>

	Options:
	  -h --help                     Show this screen
	  --format <fmt>                Report format [default: pretty]

	DOC;

    // long form, full API
    $handler = new \Docopt\Handler(array(
        'help' => true,
        'optionsFirst' => false,
    ));

    return $handler->handle($doc);
}
