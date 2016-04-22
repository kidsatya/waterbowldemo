<?php

// This is the database connection configuration.
return array(
	'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
	// uncomment the following lines to use a MySQL database
	
	/*'connectionString' => 'mysql:host=mysql1002.mochahost.com;dbname=flyon123_waterbowl',
	'emulatePrepare' => true,
	'username' => 'flyon123_waterbo',
	'password' => 'waterbowl',
	'charset' => 'utf8',*/

	'connectionString' => 'mysql:host=localhost;dbname=waterbowl',
	'emulatePrepare' => true,
	'username' => 'root',
	'password' => '',
	'charset' => 'utf8',
	
);