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

    public function __construct(ConfigDriver $driver = null)
    {
        $this->driver = $driver ?: new ChainConfigDriver(array(
            new PhpConfigDriver(),
            new YamlConfigDriver(),
            new JsonConfigDriver(),
            new TomlConfigDriver(),
        ));
    }

    public function register(Application $app)
    {
        // php 5.3 fix
        $self = $this;
        $app['config'] = $app->share(function() use($app, $self) {
            return new Config($self->driver);
        });
    }

    public function boot(Application $app)
    {
    }
}
