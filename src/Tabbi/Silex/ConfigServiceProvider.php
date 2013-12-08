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

use Silex\Application;
use Silex\ServiceProviderInterface;

class ConfigServiceProvider implements ServiceProviderInterface
{
    private $driver;
    private $path;

    public function __construct($path = null, ConfigDriver $driver = null)
    {
        $this->driver = $driver ?: new ChainConfigDriver(array(
            new PhpConfigDriver(),
            new YamlConfigDriver(),
            new JsonConfigDriver(),
            new TomlConfigDriver(),
        ));

        $this->path = $path;
    }

    public function register(Application $app)
    {
        $driver = $this->driver;
        $app['config'] = $app->share(function() use($app, &$driver) {
            return new Config($driver, $this->path);
        });
    }

    public function boot(Application $app)
    {
    }
}
