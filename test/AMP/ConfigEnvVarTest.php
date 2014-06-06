<?php
namespace AMP;

class ConfigEnvVarTest extends \PHPUnit_Framework_TestCase
{
    private $config;
    private $envvars;

    private function setEnvVar($key, $value)
    {
        $this->envvars[] = $key;
        putenv($key . '=' . $value);
    }

    private function unsetEnvVars()
    {
        foreach ($this->envvars as $envvar) {
            putenv($envvar);
        }
    }

    public function setUp()
    {
        $this->config = new Config(__DIR__ . '/../test-config.ini');
    }

    public function tearDown()
    {
        $this->unsetEnvVars();
    }

    /**
     * @test
     */
    public function gettingValidEnvironmentVariableWithNoCorrespondingConfigValueShouldReturnCorrectValue()
    {
        $this->setEnvVar('TESTVAR', 'Test Var');
        $this->assertEquals('Test Var', $this->config->get('TESTVAR'));
    }

    /**
     * @test
     */
    public function gettingValidEnvironmentVariableWithCorrespondingConfigValueShouldReturnCorrectValue()
    {
        $this->setEnvVar('someValue', 'Some Value environment var');
        $this->assertEquals('Some Value environment var', $this->config->get('someValue'));
    }

    /**
     * @test
     */
    public function gettingValidEmptyEnvironmentVariableShouldReturnCorrectValue()
    {
        $this->setEnvVar('emptyValue', '');
        $this->assertEquals('', $this->config->get('emptyValue'));
    }
}
