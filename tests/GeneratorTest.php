<?php

namespace Gendiff\Tests;

use PHPUnit\Framework\TestCase;
use function Gendiff\Generator\generate;

class GeneratorTest extends TestCase
{
    /**
     * @test
     */
    public function testGenerator()
    {
        $beforeJson = '{
  		"host": "hexlet.io",
  		"timeout": 50,
 		  "proxy": "123.234.53.22"
		}';
        $afterJson = '{
  		"timeout": 20,
  		"verbose": true,
  		"host": "hexlet.io"
		}';
        $result = <<<EOT
        {
            host: hexlet.io
          + timeout: 20
          - timeout: 50
          - proxy: 123.234.53.22
          + verbose: true
        }
        EOT;

        $this->assertEquals($result, generate($beforeJson, $afterJson));
    }
}
