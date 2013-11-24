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

namespace Tabbi\Silex;

/**
 * Test file format and file name
 * 
 * @author Igor Wiedler <igor@wiedler.ch>
 * @author Jérôme Macias <jerome.macias@gmail.com>
 * @author Tomasz Łopusiewicz <tomasz.pobieralnia@gmail.com>
 */
class GetFileFormatTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider provideFilenamesForFormat
     */
    public function testGetFileFormat($filename)
    {
        $driver = new ChainConfigDriver(array(
            new PhpConfigDriver(),
            new YamlConfigDriver(),
            new JsonConfigDriver(),
            new TomlConfigDriver(),
        ));

        $this->assertTrue($driver->supports($filename));
    }

    /**
     * @dataProvider provideFilenamesForFormat
     */
    public function testGetFileNameFormat($filename)
    {
        $driver = new ChainConfigDriver(array(
            new PhpConfigDriver(),
            new YamlConfigDriver(),
            new JsonConfigDriver(),
            new TomlConfigDriver(),
        ));

         $this->assertEquals('config', $driver->getFileName($filename));
    }

    public function provideFilenamesForFormat()
    {
        return array(
            'yaml'      => array(__DIR__."/Fixtures/config.yaml"),
            'yml'       => array(__DIR__."/Fixtures/config.yml"),
            'yaml.dist' => array(__DIR__."/Fixtures/config.yaml.dist"),
            'json'      => array(__DIR__."/Fixtures/config.json"),
            'json.dist' => array(__DIR__."/Fixtures/config.json.dist"),
            'php'       => array(__DIR__."/Fixtures/config.php"),
            'php.dist'  => array(__DIR__."/Fixtures/config.php.dist"),
            'toml'      => array(__DIR__."/Fixtures/config.toml"),
            'toml.dist' => array(__DIR__."/Fixtures/config.toml.dist"),
        );
    }
}