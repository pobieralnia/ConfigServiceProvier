<?php

namespace Tabbi\Silex;

class PhpConfigDriver implements ConfigDriver
{
    public function load($filename)
    {
        $config = require $filename;
        $config = (1 === $config) ? array() : $config;
        return $config ?: array();
    }

    public function supports($filename)
    {
        return (bool) preg_match('#\.php(\.dist)?$#', $filename);
    }

    public function getFileName($filename)
    {
        $filename = preg_replace('#(\.dist)?$#', '', $filename);
        return basename($filename, '.php');
    }
}
