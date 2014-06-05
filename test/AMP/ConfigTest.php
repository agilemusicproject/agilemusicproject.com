<?php
namespace AMP;

class ConfigTest extends \PHPUnit_Framework_TestCase
{
    private $config;

    public function setUp()
    {
        $this->config = new Config(__DIR__ . '/../test-config.ini');
    }

    /**
     * @test
     */
    public function gettingConfigKeyShouldReturnCorrectValue()
    {
        $this->assertEquals('Some Value', $this->config->get('someValue'));
    }

    /**
     * @test
     */
    public function gettingConfigKeyWithDotSeparatorShouldReturnCorrectValue()
    {
        $this->assertEquals('No Section', $this->config->get('no.section'));
    }

    /**
     * @test
     */
    public function gettingConfigKeyInsideSectionShouldReturnCorrectValue()
    {
        $this->assertEquals('Name', $this->config->get('name', 'Section1'));
    }

    /**
     * @test
     */
    public function getingConfigKeyWithDotSepartorInsideSectionShouldReturnCorrectValue()
    {
        $this->assertEquals('Prefix', $this->config->get('title.prefix', 'Section1'));
    }

    /**
     * @test
     * @expectedException \AMP\Exception\ConfigValueNotFoundException
     */
    public function gettingInvalidKeyShouldThrowException()
    {
        $this->config->get('foo');
    }

    /**
     * @test
     * @expectedException \AMP\Exception\ConfigValueNotFoundException
     */
    public function gettingInvalidKeyInsideValidSectionShouldThrowException()
    {
        $this->config->get('foo', 'Section1');
    }

    /**
     * @test
     */
    public function gettingValidEnvironmentVariableWithNoCorrespondingConfigValueShouldReturnCorrectValue()
    {
        $key = 'TESTVAR';
        $value = 'Test Var';
        putenv($key . '=' . $value);
        $this->assertEquals($value, $this->config->get($key));
    }

    /**
     * @test
     */
    public function gettingValidEnvironmentVariableWithCorrespondingConfigValueShouldReturnCorrectValue()
    {
        $key = 'someValue';
        $value = 'Some Value';
        putenv($key . '=' . $value);
        $this->assertEquals($value, $this->config->get($key));
    }

    /**
     * @test
     */
    public function gettingValidEmptyEnvironmentVariableShouldReturnCorrectValue()
    {
        $key = 'emptyValue';
        $value = '';
        putenv($key . '=' . $value);
        $this->assertEquals($value, $this->config->get($key));
    }
}
