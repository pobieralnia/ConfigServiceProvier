# ConfigServiceProvider

A config ServiceProvider for [Silex](http://silex.sensiolabs.org) with support
for php, json, yaml, and toml. It is based on Igor Wiedler [ConfigServiceProvider](https://github.com/igorw/ConfigServiceProvider).
The main diffrence is in usage. It allows now to get config options in "Laravel way". Getting config keys is very simple, first define
a folder where you will store all your config files then add all the files into it. The first level of key is file name, next levels depends
on you.

Example:

    # config/database.php
    return = array(
        'db_name' => 'test',
        'db_password' => 'password',
        'db_user' => 'user',
        'db_host' => 'localhost',
    );

The getting key will be `database.db_name`.
## Usage

### Using Yaml

To use Yaml just pass a file that ends on `.yml` or `.yaml` in add method:

    $app->register(new Tabbi\Silex\ConfigServiceProvider());
    $app['config']->add(__DIR__."/../config/services.yml");
    echo $app['config']->get('services.option.value');

Note, it requires `~2.3` - `symfony/yaml` package.

### Using TOML

To use [TOML](https://github.com/mojombo/toml) instead of any of the other supported formats,
just pass a file that ends on `.toml`:

    $app->register(new Tabbi\Silex\ConfigServiceProvider());
    $app['config']->add(__DIR__."/../config/services.toml");
    echo $app['config']->get('services.option.value');

Note, it requires `~0.1` - `jamesmoss/toml` package and you are using
a bleeding edge configuration format, as the spec of TOML is still subject to change.

### Using plain PHP

Use simple php configs that returns the array of config data, and also make sure it ends with `.php`:

    $app->register(new Tabbi\Silex\ConfigServiceProvider());
    $app['config']->add(__DIR__."/../config/services.php");
    echo $app['config']->get('services.option.value');

### Using Json

To use Json just pass a file that ends on `.json` in add method:

    $app->register(new Tabbi\Silex\ConfigServiceProvider());
    $app['config']->add(__DIR__."/../config/services.json");
    echo $app['config']->get('services.option.value');

### Multiple config files

You can use multiple config files, e. g. one for a whole application and a
specific one for a task by calling `$app['config]->add()` several times.

    $app->register(new Tabbi\Silex\ConfigServiceProvider());
    $app['config']->add(__DIR__."/../config/services.php");
    $app['config']->add(__DIR__."/../config/database.php");
    $app['config']->add(__DIR__."/../config/cache.php");
    echo $app['config']->get('services.option.value');
    echo $app['config']->get('database.option.value');
    echo $app['config']->get('cache.option.value');

### Register order

Make sure you do not register anything with `config` name. You don't have to keep
correct order just remember to add config before its usage.