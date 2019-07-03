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
        $result = <<<EOT
        {
            host: hexlet.io
          + timeout: 20
          - timeout: 50
          - proxy: 123.234.53.22
          + verbose: true
        }
        EOT;

        $this->assertEquals($result, generateDiff($path1, $path2, 'pretty'));
    }

    public function testNestedJsonFormatPretty()
    {
        $path1 = __DIR__ . "/fixtures/beforeNested.json";
        $path2 = __DIR__ . "/fixtures/afterNested.json";
        $result = <<<EOT
        {
            common: {
                setting1: Value 1
              - setting2: 200
                setting3: true
              - setting6: {
                    key: value
                }
              + setting4: blah blah
              + setting5: {
                    key5: value5
                }
            }
            group1: {
              + baz: bars
              - baz: bas
                foo: bar
            }
          - group2: {
                abc: 12345
            }
          + group3: {
                fee: 100500
            }
        }
        EOT;

        $this->assertEquals($result, generateDiff($path1, $path2, 'pretty'));
    }
    
    public function testFlatYamlFormatPretty()
    {
        $path1 = __DIR__ . "/fixtures/before.yaml";
        $path2 = __DIR__ . "/fixtures/after.yaml";
        $result = <<<EOT
        {
            host: hexlet.io
          + timeout: 20
          - timeout: 50
          - proxy: 123.234.53.22
          + verbose: true
        }
        EOT;

        $this->assertEquals($result, generateDiff($path1, $path2, 'pretty'));
    }

    public function testFlatJsonFormatPlain()
    {
        $path1 = __DIR__ . "/fixtures/before.json";
        $path2 = __DIR__ . "/fixtures/after.json";
        $result = <<<EOT
      Property 'timeout' was changed. From '50' to '20'
      Property 'proxy' was removed
      Property 'verbose' was added with value: 'true'
      EOT;

        $this->assertEquals($result, generateDiff($path1, $path2, 'plain'));
    }

    public function testNestedJsonFormatPlain()
    {
        $path1 = __DIR__ . "/fixtures/beforeNested.json";
        $path2 = __DIR__ . "/fixtures/afterNested.json";
        $result = <<<EOT
      Property 'common.setting2' was removed
      Property 'common.setting6' was removed
      Property 'common.setting4' was added with value: 'blah blah'
      Property 'common.setting5' was added with value: 'complex value'
      Property 'group1.baz' was changed. From 'bas' to 'bars'
      Property 'group2' was removed
      Property 'group3' was added with value: 'complex value'
      EOT;

        $this->assertEquals($result, generateDiff($path1, $path2, 'plain'));
    }
}
