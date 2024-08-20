<?php

namespace CacheTool\Adapter;

use CacheTool\Code;
use CacheTool\PhpFpmRunner;
use CacheTool\Adapter\FastCGI;
use \hollodotme\FastCGI\SocketConnections\NetworkSocket;
use \hollodotme\FastCGI\Requests\PostRequest;
use \hollodotme\FastCGI\Responses\Response;
class FastCGITest extends \PHPUnit\Framework\TestCase
{
    public function testRun()
    {
        $fpm = new PhpFpmRunner();
        $fcgi = new FastCGI($fpm->socket);
        $fcgi->setTempDir(sys_get_temp_dir());
        $fcgi->setLogger(new \Psr\Log\NullLogger());

        $code = Code::fromString('return true;');

        $result = $fcgi->run($code);
        $this->assertTrue($result);
    }

    public function testGetScriptFileNameWithChroot()
    {
        $tmpdir = sys_get_temp_dir();
        $fcgi = new FastCGI(null, $tmpdir);
        $class = new \ReflectionClass($fcgi);
        $method = $class->getMethod('getScriptFileName');
        $method->setAccessible(true);

        $this->assertSame('/test.php', $method->invoke($fcgi, "{$tmpdir}/test.php"));
    }

    public function testGetScriptFileNameWithoutChroot()
    {
        $fcgi = new FastCGI(null);
        $class = new \ReflectionClass($fcgi);
        $method = $class->getMethod('getScriptFileName');
        $method->setAccessible(true);

        $this->assertSame('/tmp/test.php', $method->invoke($fcgi, '/tmp/test.php'));
    }

    public function testRunWithChroot()
    {
        $fcgi = $this->getMockBuilder(FastCGI::class)
            ->setMethods(['getScriptFileName'])
            ->setConstructorArgs(['127.0.0.1:9000', sys_get_temp_dir()])
            ->getMock();

        $reflection = new \ReflectionClass($fcgi);
        $reflectionClient = $reflection->getProperty('client');
        $reflectionClient->setAccessible(true);

        $clientMock = $this->getMockBuilder(\hollodotme\FastCGI\Client::class)
            ->disableOriginalConstructor()
            ->getMock();
        $reflectionClient->setValue($fcgi, $clientMock);

        $fileName = '/tmp/testRunWithChroot/test.php';
        $fcgi->expects(self::once())
            ->method('getScriptFileName')
            ->willReturn($fileName);

        $connectionMock = new NetworkSocket('127.0.0.1', '9000', 5000, 120000);
        $request = new PostRequest($fileName, '');
        $response = new Response("Content-type: text/html; charset=UTF-8\r\n\r\na:2:{s:6:\"result\";b:1;s:6:\"errors\";a:0:{}}", '', 0);

        $clientMock->expects(self::once())
            ->method('sendRequest')
            ->with($connectionMock, $request)
            ->willReturn($response);

        $fcgi->setTempDir(sys_get_temp_dir());
        $fcgi->setLogger(new \Psr\Log\NullLogger());

        $code = Code::fromString('return true;');

        $result = $fcgi->run($code);
        $this->assertTrue($result);
    }

    public function testRunWithIPv4()
    {
        $fcgi = new FastCGI('127.0.0.1:9000');

        $reflection = new \ReflectionClass($fcgi);
        $reflectionConn = $reflection->getProperty('connection');
        $reflectionConn->setAccessible(true);
        $connection = $reflectionConn->getValue($fcgi);

        $reflection = new \ReflectionClass($connection);
        $reflectionHost = $reflection->getProperty('host');
        $reflectionHost->setAccessible(true);

        $this->assertSame('127.0.0.1', $reflectionHost->getValue($connection));
    }

    public function testRunWithIPv6()
    {
        $fcgi = new FastCGI(':::9000');

        $reflection = new \ReflectionClass($fcgi);
        $reflectionConn = $reflection->getProperty('connection');
        $reflectionConn->setAccessible(true);
        $connection = $reflectionConn->getValue($fcgi);

        $reflection = new \ReflectionClass($connection);
        $reflectionHost = $reflection->getProperty('host');
        $reflectionHost->setAccessible(true);

        $this->assertSame('[::]', $reflectionHost->getValue($connection));
    }
}
