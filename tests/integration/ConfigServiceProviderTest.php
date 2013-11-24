<?php

/**
 * This file is part of ConfigServiceProvider.
 *
 * (c) Tomasz Lopusiewicz <tomasz.pobieralnia@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author (c) Igor Wiedler <igor@wiedler.ch>
 * @see https://github.com/igorw/ConfigServiceProvider
 */

use Silex\Application;
use Tabbi\Silex\ConfigServiceProvider;

/**
 * Test file format and file name
 * 
 * @author Igor Wiedler <igor@wiedler.ch>
 * @author Jérôme Macias <jerome.macias@gmail.com>
 * @author Tomasz Łopusiewicz <tomasz.pobieralnia@gmail.com>
 */
class ConfigServiceProviderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider provideEmptyFilenames
     */
    public function testEmptyConfigs($filename)
    {
        $readConfigMethod = new \ReflectionMethod('Tabbi\Silex\ConfigServiceProvider', 'readConfig');
        $readConfigMethod->setAccessible(true);

        $this->assertEquals(
            array(),
            $readConfigMethod->invoke(new ConfigServiceProvider($filename))
        );
    }

    /**
     * @test
     * @expectedException RuntimeException
     * @expectedExceptionMessage Invalid JSON provided "Syntax error" in
     */
    public function invalidJsonShouldThrowException()
    {
        $app = new Application();
        $app->register(new ConfigServiceProvider());
        $app['config']->add(__DIR__."/Fixtures/broken.json");
    }

    /**
     * @test
     * @expectedException Symfony\Component\Yaml\Exception\ParseException
     */
    public function invalidYamlShouldThrowException()
    {
        $app = new Application();
        $app->register(new ConfigServiceProvider());
        $app['config']->add(__DIR__."/Fixtures/broken.yml");
    }

    /**
     * @test
     * @expectedException \Exception
     */
    public function invalidTomlShouldThrowException()
    {
        $app = new Application();
        $app->register(new ConfigServiceProvider());
        $app['config']->add(__DIR__."/Fixtures/broken.toml");
    }

    public function provideFilenames()
    {
        return array(
            array(__DIR__."/Fixtures/config.php"),
            array(__DIR__."/Fixtures/config.json"),
            array(__DIR__."/Fixtures/config.yml"),
            array(__DIR__."/Fixtures/config.toml"),
        );
    }

    public function provideReplacementFilenames()
    {
        return array(
            array(__DIR__."/Fixtures/config_replacement.php"),
            array(__DIR__."/Fixtures/config_replacement.json"),
            array(__DIR__."/Fixtures/config_replacement.yml"),
            array(__DIR__."/Fixtures/config_replacement.toml"),
        );
    }

    public function provideEmptyFilenames()
    {
        return array(
            array(__DIR__."/Fixtures/config_empty.php"),
            array(__DIR__."/Fixtures/config_empty.json"),
            array(__DIR__."/Fixtures/config_empty.yml"),
            array(__DIR__."/Fixtures/config_empty.toml"),
        );
    }

    public function provideMergeFilenames()
    {
        return array(
            array(__DIR__."/Fixtures/config_base.php", __DIR__."/Fixtures/config_extend.php"),
            array(__DIR__."/Fixtures/config_base.json", __DIR__."/Fixtures/config_extend.json"),
            array(__DIR__."/Fixtures/config_base.yml", __DIR__."/Fixtures/config_extend.yml"),
        );
    }
}