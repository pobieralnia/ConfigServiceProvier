<?php

namespace Tabbi\Silex;

interface ConfigDriver
{
    function load($filename);
    function supports($filename);
    function getFileName($filename);
}
