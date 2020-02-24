<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use SideKit\Config\ConfigKit;
use SideKit\Config\TestConfigurationBuilder;

final class BasicTest extends TestCase
{
    public function testAssert(): void
    {
        $root = dirname(__DIR__);
        $builder = new TestConfigurationBuilder();
        ConfigKit::config()
            ->useConfigurationBuilder($builder)
            ->useRootPath($root)
            ->useConfigPath($root . '/tests/fixture/');
        $test = ConfigKit::config()->build('test');

        $this->assertIsArray($test);
        $this->assertArrayHasKey("id",$test);
        $this->assertNotEmpty($test["id"]);
        $this->assertArrayHasKey("components",$test);
        $this->assertIsArray($test["components"]);
    }


    public function testLoadDotEnv()
    {
        $dotenv = Dotenv\Dotenv::createImmutable(__DIR__.'/fixture',['env']);
        $dotenv->load();
        $this->assertEquals(getenv('ENVIRONMENT'),'testing');

    }


    public function testLoadEnv()
    {
        $root = dirname(__DIR__.'/fixture/');
        ConfigKit::config()->useRootPath( $root);
        $environment = ConfigKit::env();

        $environment->load();
        $this->assertEquals(getenv('ENVIRONMENT2'),'testing2');

    }
}
