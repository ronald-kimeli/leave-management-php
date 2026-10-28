<?php

// Autoload classes
require_once __DIR__ . '/../vendor/autoload.php';

use app\database\Migration;

// Each entry runs once and is recorded in the `migrations` table.
// To change a table later, append a new entry with a later timestamp id, e.g.
//   ['id' => '2026_11_02_093000_add_phone_to_users', 'type' => 'add_columns', 'table' => 'users',
//    'up' => function ($table) { $table->string('phone', 20)->nullable(); }],
// Never edit an entry that has already run.
$migrations = [
    [
        'id' => '2024_01_01_000001_create_departments_table',
        'type' => 'create',
        'table' => 'departments',
        'up' => function ($table) {
            $table->increments('id');
            $table->string('name', 255)->required()->unique()->comments("Department's name");
            $table->longText('description')->nullable()->comments("Department's description");
            $table->timestamps();
        },
    ],
    [
        'id' => '2024_01_01_000002_create_roles_table',
        'type' => 'create',
        'table' => 'roles',
        'up' => function ($table) {
            $table->increments('id');
            $table->string('name', 255)->required()->unique()->comments("Role's name");
            $table->longText('description')->nullable()->comments("Role's description");
            $table->string('permissions')->nullable()->comments("Role's permissions (comma-separated)");
            $table->timestamps();
        },
    ],
    [
        'id' => '2024_01_01_000003_create_leavetypes_table',
        'type' => 'create',
        'table' => 'leavetypes',
        'up' => function ($table) {
            $table->increments('id');
            $table->string('name', 255)->required()->unique()->comments("Leave type's name");
            $table->longText('description')->nullable()->comments("Leave type's description");
            $table->integer('minimum_period')->required()->default(0)->comments("Minimum leave period");
            $table->timestamps();
        },
    ],
    [
        'id' => '2024_01_01_000004_create_users_table',
        'type' => 'create',
        'table' => 'users',
        'up' => function ($table) {
            $table->increments('id');
            $table->string('first_name', 191)->required()->comments("User's first name");
            $table->string('last_name', 191)->required()->comments("User's last name");
            $table->string('gender', 50)->required()->comments("User's gender");
            $table->foreign('department_id')->references('departments', 'id')->cascade()->onDelete()->comments("Foreign key to departments table");
            $table->string('email', 191)->unique()->comments("User's email address");
            $table->string('password', 191)->required()->comments("User's hashed password");
            $table->string('verify_token', 191)->required()->comments("User's verification token");
            $table->string('verify_status')->required()->default('pending')->comments("Verify status");
            $table->foreign('role_id')->default(3)->references('roles', 'id')->cascade()->onDelete()->comments("Foreign key to roles table");
            $table->string('status')->required()->default('active')->comments("User status");
            $table->string('reset_token', 255)->nullable()->comments("User's reset token");
            $table->datetime('reset_token_expiration')->nullable()->comments("Expiration date for reset token");
            $table->timestamps();
        },
    ],
    [
        'id' => '2024_01_01_000005_create_appliedleaves_table',
        'type' => 'create',
        'table' => 'appliedleaves',
        'up' => function ($table) {
            $table->increments('id');
            $table->foreign('applied_by')->references('users', 'id')->cascade()->onDelete()->comments("Foreign key to users table");
            $table->foreign('leavetype_id')->references('leavetypes', 'id')->cascade()->onDelete()->comments("Foreign key to users table - creator of leavetype");
            $table->string('description')->nullable()->comments("Leave description");
            $table->date('from_date')->required()->unique()->comments("Start date of leave");
            $table->date('to_date')->required()->unique()->comments("End date of leave");
            $table->string('status')->required()->default('pending')->comments("Leave status");
            $table->integer('remaining_days')->nullable()->comments("Time remaining after acceptance");
            $table->timestamps();
        },
    ],
];

$args = array_slice($argv, 1);
$fresh = in_array('--fresh', $args, true);
$tableName = current(array_filter($args, fn($a) => strpos($a, '--') !== 0)) ?: null;

$migration = new Migration();

if ($fresh) {
    $response = readline("--fresh drops ALL tables in the database and all their data. Type 'yes' to continue: ");
    if (strtolower(trim($response)) !== 'yes') {
        echo "Aborted.\n";
        exit(1);
    }
    $migration->fresh();
}

$migration->run($migrations, $tableName);
