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
        $this->assertEquals("Some Value", $this->config->get("someValue"));
    }

    /**
     * @test
     */
    public function gettingConfigKeyWithDotSeparatorShouldReturnCorrectValue()
    {
        $this->assertEquals("No Section", $this->config->get("no.section"));
    }

    /**
     * @test
     */
    public function gettingConfigKeyInsideSectionShouldReturnCorrectValue()
    {
        $this->assertEquals("Name", $this->config->get("name", "Section1"));
    }

    /**
     * @test
     */
    public function getingConfigKeyWithDotSepartorShouldReturnCorrectValue()
    {
        $this->assertEquals("Prefix", $this->config->get("title.prefix", "Section1"));
    }
}
