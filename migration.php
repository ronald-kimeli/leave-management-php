<?php

// Autoload classes
require_once 'vendor/autoload.php';

use app\database\Migration;

// Function to define table schemas
function defineTableSchemas($tableName, Migration $migration)
{
    switch ($tableName) {
        case 'users':
            $migration->executeTable('users', function ($table) {
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
                $table->date('reset_token_expiration')->nullable()->comments("Expiration date for reset token");
                $table->timestamps();
            });
            break;
        case 'roles':
            $migration->executeTable('roles', function ($table) {
                $table->increments('id');
                $table->string('name', 255)->required()->unique()->comments("Role's name");
                $table->longText('description')->nullable()->comments("Role's description");
                $table->string('permissions')->nullable()->comments("Role's permissions (comma-separated)");
                $table->timestamps();
            });
            break;
        case 'departments':
            $migration->executeTable('departments', function ($table) {
                $table->increments('id');
                $table->string('name', 255)->required()->unique()->comments("Department's name");
                $table->longText('description')->nullable()->comments("Department's description");
                $table->timestamps();
            });
            break;
        case 'leavetypes':
            $migration->executeTable('leavetypes', function ($table) {
                $table->increments('id');
                $table->string('name', 255)->required()->unique()->comments("Leave type's name");
                $table->longText('description')->nullable()->comments("Leave type's description");
                $table->integer('minimum_period')->required()->default(0)->comments("Minimum leave period");
                $table->timestamps();
            });
            break;
        case 'appliedleaves':
            $migration->executeTable('appliedleaves', function ($table) {
                $table->increments('id');
                $table->foreign('applied_by')->references('users', 'id')->cascade()->onDelete()->comments("Foreign key to users table");
                $table->foreign('leavetype_id')->references('leavetypes', 'id')->cascade()->onDelete()->comments("Foreign key to users table - creator of leavetype");
                $table->string('description')->nullable()->comments("Leave description");
                $table->date('from_date')->required()->unique()->comments("Start date of leave");
                $table->date('to_date')->required()->unique()->comments("End date of leave");
                $table->string('status')->required()->default('pending')->comments("Leave status");
                $table->integer('remaining_days')->nullable()->comments("Time remaining after acceptance");
                $table->timestamps();
            });
            break;
        default:
            echo "No migration defined for table '$tableName'.\n";
    }
}

// Create an instance of the Migration class
$migration = new Migration();

// Check if a specific table was provided as an argument
$tableName = $argv[1] ?? null;

if ($tableName) {
    // Migrate the specified table
    defineTableSchemas($tableName, $migration);
} else {
    // Migrate all tables
    $tables = ['departments', 'roles', 'leavetypes', 'users', 'appliedleaves'];
    foreach ($tables as $table) {
        defineTableSchemas($table, $migration);
    }
}