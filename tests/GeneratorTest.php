<?php

namespace Gendiff\Tests;

use PHPUnit\Framework\TestCase;
use function Gendiff\Generator\generate;

class GeneratorTest extends TestCase
{
    /**
     * @test
     */
    public function testJson()
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

        $this->assertEquals($result, generate($path1, $path2));
    }
    
    /**
     * @test
     */
    public function testYaml()
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

        $this->assertEquals($result, generate($path1, $path2));
    }
}
