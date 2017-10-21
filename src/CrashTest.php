<?php

declare(strict_types=1);
use PHPUnit\Framework\TestCase;
require "vendor/autoload.php";

class CrashTest extends TestCase
{
    public function testJsonEncodeEscaping()
    {
        $string = 'this\\/should/be/escaped';
        $from = new TestMessage();
        $from->setOptionalString($string);
        $data = $from->serializeToJsonString();
        $to = new TestMessage();
        $to->mergeFromJsonString($data);
        $this->assertEquals(
            $from->getOptionalString(),
            $to->getOptionalString()
        );
    }
    public function testJsonEncodeEscapeForwardSlash()
    {
        $string = 'this\\/should/be/escaped';
        $from = new TestMessage();
        $from->setOptionalString($string);
        $data = $from->serializeToJsonString();
        $this->assertContains(json_encode($string), $data);
    }

    /** @dataProvider provideJsonEncodeEscaping **/
    public function testJsonEncodeEscaping2($string)
    {
        $from = new TestMessage();
        $from->setOptionalString($string);
        $data = $from->serializeToJsonString();
        $to = new TestMessage();
        $to->mergeFromJsonString($data);
        $this->assertEquals(
            $from->getOptionalString(),
            $to->getOptionalString()
        );
        $this->assertContains(json_encode($string), $data);
    }

    public function provideJsonEncodeEscaping()
    {
        return [
            // these values fail
            ['escape/forward/slashes'],
            ['escape\\back\\slashes'],
            ["escape\nnewlines"],
            ['escape "double" quotes'],

            // these values pass
            ['escape \'single\' quotes'],
            ['escape {curly} braces'],
            ['escape [square] brackets'],
        ];
    }
}
