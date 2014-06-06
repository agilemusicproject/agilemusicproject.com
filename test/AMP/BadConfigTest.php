<?php
namespace AMP;

class BadConfigTest extends \PHPUnit_Framework_TestCase
{
    private $config;

    public function setUp()
    {
        $this->config = new Config(__DIR__ . '/../bad-config.ini');
    }

    /**
     * @test
     */
    public function constructingWithNonexistentConfigFileShouldNotError()
    {
        $this->assertInstanceOf('\AMP\Config', $this->config);
    }

    /**
     * @test
     * @expectedException \AMP\Exception\ConfigValueNotFoundException
     */
    public function gettingValueFromConfigWithNonexistentFileWithoutEnvironmentVarShouldThrowException()
    {
        $this->config->get('foo');
    }

    /**
     * @test
     */
    public function gettingValueFromConfigWithNonexistentFileWithEnvironmentVarShouldThrowException()
    {
        $key = 'TESTVAR';
        $value = 'Test Var';
        putenv($key . '=' . $value);
        $this->assertEquals($value, $this->config->get($key));
    }
}
