<?php

namespace Gendiff\Tests;

use PHPUnit\Framework\TestCase;
use function Gendiff\Generator\generateDiff;

class GeneratorTest extends TestCase
{
    public function testFlatJsonFormatPretty()
    {
        $path1 = __DIR__ . "/fixtures/before.json";
        $path2 = __DIR__ . "/fixtures/after.json";
        $result = file_get_contents(__DIR__ . "/fixtures/expected/flatPrettyJson");

        $this->assertEquals($result, generateDiff($path1, $path2, 'pretty'));
    }

    public function testNestedJsonFormatPretty()
    {
        $path1 = __DIR__ . "/fixtures/beforeNested.json";
        $path2 = __DIR__ . "/fixtures/afterNested.json";
        $result = file_get_contents(__DIR__ . "/fixtures/expected/nestedPrettyJson");

        $this->assertEquals($result, generateDiff($path1, $path2, 'pretty'));
    }
    
    public function testFlatYamlFormatPretty()
    {
        $path1 = __DIR__ . "/fixtures/before.yaml";
        $path2 = __DIR__ . "/fixtures/after.yaml";
        $result = file_get_contents(__DIR__ . "/fixtures/expected/flatPrettyYaml");

        $this->assertEquals($result, generateDiff($path1, $path2, 'pretty'));
    }

    public function testFlatJsonFormatPlain()
    {
        $path1 = __DIR__ . "/fixtures/before.json";
        $path2 = __DIR__ . "/fixtures/after.json";
        $result = file_get_contents(__DIR__ . "/fixtures/expected/flatPlainJson");

        $this->assertEquals($result, generateDiff($path1, $path2, 'plain'));
    }

    public function testNestedJsonFormatPlain()
    {
        $path1 = __DIR__ . "/fixtures/beforeNested.json";
        $path2 = __DIR__ . "/fixtures/afterNested.json";
        $result = file_get_contents(__DIR__ . "/fixtures/expected/nestedPlainJson");

        $this->assertEquals($result, generateDiff($path1, $path2, 'plain'));
    }
}
