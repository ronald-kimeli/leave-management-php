<?php

use app\database\Seeder;

// Autoload classes
require_once 'vendor/autoload.php';

$seeder = new Seeder();
$seeder->seedTable('departments');
$seeder->seedTable('roles');
$seeder->seedTable('leavetypes');
$seeder->seedTable('users');
$seeder->seedTable('appliedleaves');
