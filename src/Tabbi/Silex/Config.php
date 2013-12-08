<?php

namespace Tabbi\Silex;

final class Config implements ConfigInterface {
	
    /**
     * Config Driver
     * 
     * @var object
     */
	private $driver;

    /**
     * Settings container
     * 
     * @var array
     */
	private $config = array();

    /**
     * Contructor
     * 
     * @param ConfigDriver $driver
     */
	public function __construct(ConfigDriver $driver, $path = null)
	{
		$this->driver = $driver;

        // try to autoload all files in directory
        if($path)
        {
            if ($handle = opendir($path))
            {
                while (false !== ($entry = readdir($handle)))
                {
                    if ($entry == '.' || $entry == '..') continue;

                    $this->add($path . $entry);
                }

                closedir($handle);
            }
            else
            {
                throw new \RuntimeException('A valid configuration path must be passed before reading configs.');
            }
        }
	}

    /**
     * Add new config into settings container
     * 
     * @param string $filename File name with path
     * @see   Config::readConfig()
     */
	public function add($filename)
	{
		$configTmp = $this->readConfig($filename);
        $configFileName = $this->driver->getFileName($filename);

        $config[$configFileName] = $configTmp;
		$this->config = array_merge($this->config, $config);
	}

    /**
     * Get settings value
     * 
     * @param  string $key     A key where settings are stored ex.
     *                         error.exception.name Where first art is config
     *                         file name.
     * @param  mixed $default  Default value returned when key was not found
     * @return mixed
     */
	public function get($key, $default = null)
	{
		return $this->array_get($this->config, $key, $default);
	}

    /**
     * Set new settings
     * 
     * @param string $key
     * @param mixed $value
     */
    public function set($key, $value)
    {
        $this->config[$key] = $value;
    }

    /**
     * Try to read config before merge
     * 
     * @param  string $filename
     * @throws \RuntimeException
     * @throws \InvalidArgumentException
     */
	private function readConfig($filename)
    {
        if (!$filename) {
            throw new \RuntimeException('A valid configuration file must be passed before reading the config.');
        }

        if (!file_exists($filename)) {
            throw new \InvalidArgumentException(
                sprintf("The config file '%s' does not exist.", $filename));
        }

        if ($this->driver->supports($filename)) {
            return $this->driver->load($filename);
        }

        throw new \InvalidArgumentException(
                sprintf("The config file '%s' appears to have an invalid format.", $filename));
    }

    /**
     * Get an item from an array using "dot" notation.
     *
     * @param  array   $array
     * @param  string  $key
     * @param  mixed   $default
     * @return mixed
     */
    private function array_get($array, $key, $default = null)
    {
        if (is_null($key)) return $array;

        if (isset($array[$key])) return $array[$key];

        foreach (explode('.', $key) as $segment)
        {
            if ( ! is_array($array) || ! array_key_exists($segment, $array))
            {
                return $this->value($default);
            }

            $array = $array[$segment];
        }

        return $array;
    }

    /**
     * Return the default value of the given value.
     *
     * @param  mixed  $value
     * @return mixed
     */
    private function value($value)
    {
        return $value instanceof Closure ? $value() : $value;
    }
}