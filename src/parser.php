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

    if (isset($args['<firstFile>']) && isset($args['<secondFile>'])) {
        $filePath1 = $args['<firstFile>'];
        $filePath2 = $args['<secondFile>'];
        if (!file_exists($filePath1) && !file_exists($filePath1)) {
            exit("File {$filePath1} does not exist\nFile {$filePath2} does not exist\n");
        }
        if (!file_exists($filePath1)) {
            exit("File {$filePath1} does not exist\n");
        } if (!file_exists($filePath2)) {
            exit("File {$filePath2} does not exist\n");
        }
    }
    return generate($filePath1, $filePath2);
}
