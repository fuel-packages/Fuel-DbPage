<?php

/**
 * Fuel is a fast, lightweight, community driven PHP5 framework.
 *
 * @package		Fuel
 * @version		1.0
 * @author		Fuel Development Team
 * @license		MIT License
 * @copyright	2010 - 2011 Fuel Development Team
 * @link		http://fuelphp.com
 */

/**
 * FuelPHP DbPage Package
 *
 * @author     Phil Foulston
 * @version    1.0
 * @package    Fuel
 * @subpackage DbPage
 */

Autoloader::add_core_namespace('DbPage');

Autoloader::add_classes(array(
	'DbPage\\DbPage'             => __DIR__.'/classes/dbpage.php',
));


/* End of file bootstrap.php */