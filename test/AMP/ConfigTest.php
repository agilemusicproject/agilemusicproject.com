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
     * @expectedException \AMP\Exception\FileNotFoundException
     */
    public function constructingConfigWithNonexistentFileShouldThrowException()
    {
        $config = new Config(__DIR__ . '/../bad-config.ini');
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
     * @expectedException \AMP\Exception\ConfigValueNotFoundException
     */
    public function gettingInvalidKeyInsideInvalidSectionShouldThrowException()
    {
        $this->config->get('foo', 'bar');
    }

    /**
     * @test
     * @expectedException \AMP\Exception\ConfigValueNotFoundException
     */
    public function gettingValidKeyInsideInvalidSectionShouldThrowException()
    {
        $this->config->get('someValue', 'bar');
    }
}
