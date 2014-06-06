<?php
namespace AMP;

class NullFilenameConfigTest extends \PHPUnit_Framework_TestCase
{
    private $config;

    public function setUp()
    {
        $this->config = new Config();
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
