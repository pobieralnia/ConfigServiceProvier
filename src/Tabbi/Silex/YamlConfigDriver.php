<?php

namespace Tabbi\Silex;

use Symfony\Component\Yaml\Yaml;

class YamlConfigDriver implements ConfigDriver
{
    public function load($filename)
    {
        if (!class_exists('Symfony\\Component\\Yaml\\Yaml')) {
            throw new \RuntimeException('Unable to read yaml as the Symfony Yaml Component is not installed.');
        }
        $config = Yaml::parse($filename);
        return $config ?: array();
    }

    public function supports($filename)
    {
        return (bool) preg_match('#\.ya?ml(\.dist)?$#', $filename);
    }

    public function getFileName($filename)
    {
        $filename = preg_replace('#(\.dist)?$#', '', $filename);

        // We have yaml and yml options
        return basename($filename, '.' . pathinfo($filename, PATHINFO_EXTENSION));
    }
}
