<?php

namespace Gendiff\Tests;

use PHPUnit\Framework\TestCase;
use function Gendiff\Generator\generateDiff;

class GeneratorTest extends TestCase
{
    /**
     * @test
     */
    public function testFlatJson()
    {
        $path1 = __DIR__ . "/examples/before.json";
        $path2 = __DIR__ . "/examples/after.json";
        $result = <<<EOT
        {
            host: hexlet.io
          + timeout: 20
          - timeout: 50
          - proxy: 123.234.53.22
          + verbose: true
        }
        EOT;

        $this->assertEquals($result, generateDiff($path1, $path2));
    }

    /**
     * @test
     */
    public function testNestedJson()
    {
      $path1 = __DIR__ . "/examples/beforeNested.json";
      $path2 = __DIR__ . "/examples/afterNested.json";
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

        $this->assertEquals($result, generateDiff($path1, $path2));
    }
    
    /**
     * @test
     */
    public function testFlatYaml()
    {
        $path1 = __DIR__ . "/examples/before.yaml";
        $path2 = __DIR__ . "/examples/after.yaml";
        $result = <<<EOT
        {
            host: hexlet.io
          + timeout: 20
          - timeout: 50
          - proxy: 123.234.53.22
          + verbose: true
        }
        EOT;

        $this->assertEquals($result, generateDiff($path1, $path2));
    }
}
