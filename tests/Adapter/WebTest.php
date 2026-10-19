<?php

namespace CacheTool\Adapter;

use CacheTool\Adapter\Http\SymfonyHttpClient;
use CacheTool\Code;

class WebTest extends \PHPUnit\Framework\TestCase
{
    public function testRun()
    {
        $httpMock = $this->getMockBuilder(SymfonyHttpClient::class)->disableOriginalConstructor()->getMock();
        $httpMock
            ->method('fetch')
            ->willReturn(serialize(['errors' => [], 'result' => true]));

        $web = new Web(sys_get_temp_dir(), $httpMock);
        $web->setTempDir(sys_get_temp_dir());
        $web->setLogger(new \Psr\Log\NullLogger());

        $this->assertSame(sys_get_temp_dir(), $web->getTempDir());
        $code = Code::fromString('return true;');

        $result = $web->run($code);
        $this->assertTrue($result);
    }

    public function testFailCreateFile()
    {
        $this->expectException(\RuntimeException::class);

        $httpMock = $this->getMockBuilder(SymfonyHttpClient::class)->disableOriginalConstructor()->getMock();
        $httpMock
            ->method('fetch')
            ->willReturn(serialize(['errors' => [], 'result' => true]));

        $web = new Web("^", $httpMock);
        $web->setLogger(new \Psr\Log\NullLogger());

        $code = Code::fromString('return true;');

        $result = $web->run($code);
    }

    public function testFailUnserialize()
    {
        $this->expectException(\RuntimeException::class);

        $httpMock = $this->getMockBuilder(SymfonyHttpClient::class)->disableOriginalConstructor()->getMock();
        $httpMock
            ->method('fetch')
            ->willReturn("");

        $web = new Web(sys_get_temp_dir(), $httpMock);
        $web->setLogger(new \Psr\Log\NullLogger());

        $code = Code::fromString('return true;');

        $result = $web->run($code);
    }

    public function testFailChmodFile()
    {
        if (function_exists('posix_getuid') && posix_getuid() === 0) {
            $this->markTestSkipped('root can chmod /dev/null');
        }

        $httpMock = $this->getMockBuilder(SymfonyHttpClient::class)->disableOriginalConstructor()->getMock();

        // /dev/null accepts touch() but only its owner can chmod() it
        $web = new class('/dev', $httpMock) extends Web {
            protected function createFilename()
            {
                return 'null';
            }
        };
        $web->setLogger(new \Psr\Log\NullLogger());

        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('Could not chmod file: null');
        $web->run(Code::fromString('return true;'));
    }
}
