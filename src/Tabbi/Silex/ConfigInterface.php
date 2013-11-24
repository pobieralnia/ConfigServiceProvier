<?php

namespace Tabbi\Silex;

interface ConfigInterface {
	public function get($key, $default = '');
	public function add($filename);
	public function set($key, $value);
}