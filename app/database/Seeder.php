<?php

namespace app\database;

use app\database\Database;
use Faker\Factory as FakerFactory;

class Seeder
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function seedTable($tableName)
    {
        $response = readline("Do you want to seed table '$tableName'? (yes/no): ");
        if (empty($response) || strtolower($response) === 'yes' || strtolower($response) === 'y') {
            $this->seed($tableName);
        } else {
            echo "Seeding for table '$tableName' skipped.";
        }
    }

    public function seed($tableName)
    {
        switch ($tableName) {
            case 'users':
                $this->seedUsers();
                break;
            case 'departments':
                $this->seedDepartments();
                break;
            case 'roles':
                $this->seedRoles();
                break;
            case 'leavetypes':
                $this->seedLeaveTypes();
                break;
            case 'appliedleaves':
                $this->seedAppliedLeaves();
                break;
            default:
                echo "No seeding defined for table '$tableName'.";
        }
    }
    public function seedUsers($count = 20)
    {
        $startTime = microtime(as_float: true);
        $faker = FakerFactory::create();

        // Custom user data
        $customUsers = [
            ['first_name' => 'Janet', 'last_name' => 'Beller', 'gender' => 'Female', 'email' => 'employee@gmail.com', 'role_id' => 3, 'verify_status' => 'verified'],
            ['first_name' => 'John', 'last_name' => 'Doe', 'gender' => 'Male', 'email' => 'admin@gmail.com', 'role_id' => 1, 'verify_status' => 'verified']
        ];

        for ($i = 0; $i < $count; $i++) {
            if ($i < count($customUsers)) {
                // Use custom user data
                $first_name = $customUsers[$i]['first_name'];
                $last_name = $customUsers[$i]['last_name'];
                $gender = $customUsers[$i]['gender'];
                $email = $customUsers[$i]['email'];
                $role_id = $customUsers[$i]['role_id'];
                $verify_status = $customUsers[$i]['verify_status'];
            } else {
                // Use Faker data for other users
                $first_name = $faker->firstName;
                $last_name = $faker->lastName;
                $gender = $faker->randomElement(['Male', 'Female']);
                $email = $faker->unique()->safeEmail;
                $role_id = $faker->numberBetween(1, 10);
                $verify_status = $faker->randomElement(['verified', 'pending']);
            }

            $department_id = $faker->numberBetween(1, 10); // Assuming departments already seeded
            $password = password_hash('12345678', PASSWORD_DEFAULT);
            $verify_token = md5($email);
            $status = $faker->randomElement(['active', 'disabled']);
            $reset_token = null;
            $reset_token_expiration = $faker->dateTimeBetween('-1 year', '+1 year')->format('Y-m-d H:i:s');

            $sql = "INSERT INTO users (first_name, last_name, gender, department_id, email, password, verify_token, verify_status, role_id, status, reset_token, reset_token_expiration) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $this->db->getConnection()->prepare($sql);
            $stmt->execute([$first_name, $last_name, $gender, $department_id, $email, $password, $verify_token, $verify_status, $role_id, $status, $reset_token, $reset_token_expiration]);
        }

        $duration = round(microtime(true) - $startTime);
        echo "\033[1;32mUsers seeded successfully! -----> {$duration}s\033[0m\n\n";
    }


    public function seedDepartments($count = 20)
    {
        $startTime = microtime(as_float: true);
        $faker = FakerFactory::create();

        // Array of real department names
        $realDepartments = [
            'Human Resources',
            'Finance',
            'Marketing',
            'Sales',
            'IT',
            'Customer Service',
            'Research and Development',
            'Production',
            'Quality Assurance',
            'Logistics',
            'Legal',
            'Procurement',
            'Public Relations',
            'Administration',
            'Engineering',
            'Operations',
            'Training and Development',
            'Health and Safety',
            'Compliance',
            'Executive'
        ];

        for ($i = 0; $i < $count; $i++) {
            if ($i < count($realDepartments)) {
                // Use real department names
                $name = $realDepartments[$i];
            } else {
                // Use Faker data if more than the predefined departments are needed
                $name = $faker->company;
            }
            $description = $faker->paragraph;

            $sql = "INSERT INTO departments (name, description) VALUES (?, ?)";
            $stmt = $this->db->getConnection()->prepare($sql);
            $stmt->execute([$name, $description]);
        }

        $duration = round(microtime(true) - $startTime);
        echo "\033[1;32mDepartments seeded successfully! -----> {$duration}s\033[0m\n\n";
    }


    public function seedRoles($count = 20)
    {
        $startTime = microtime(as_float: true);
        $faker = FakerFactory::create();

        // Array to hold custom roles
        $customRoles = [
            ['name' => 'admin', 'description' => 'Administrator role', 'permissions' => 'all'],
            ['name' => 'guest', 'description' => 'Guest role', 'permissions' => 'read-only'],
            ['name' => 'employee', 'description' => 'Employee role', 'permissions' => 'read, write']
        ];

        // Array of possible permissions
        $possiblePermissions = [
            'read',
            'write',
            'update',
            'delete',
            'create',
            'manage',
            'view',
            'edit',
            'execute',
            'administer'
        ];

        for ($i = 0; $i < $count; $i++) {
            if ($i < count($customRoles)) {
                // Use custom role data
                $name = $customRoles[$i]['name'];
                $description = $customRoles[$i]['description'];
                $permissions = $customRoles[$i]['permissions'];
            } else {
                // Use Faker data for name and description
                $name = $faker->jobTitle;
                $description = $faker->paragraph;

                // Randomly select 5 permissions from the possiblePermissions array
                $randomPermissions = $faker->randomElements($possiblePermissions, 5);
                $permissions = implode(', ', $randomPermissions);
            }

            $sql = "INSERT INTO roles (name, description, permissions) VALUES (?, ?, ?)";
            $stmt = $this->db->getConnection()->prepare($sql);
            $stmt->execute([$name, $description, $permissions]);
        }

        $duration = round(microtime(true) - $startTime);
        echo "\033[1;32mRoles seeded successfully! -----> {$duration}s\033[0m\n\n";
    }

    public function seedLeaveTypes($count = 20)
    {

        $startTime = microtime(as_float: true);

        // Define a list of leave types with their descriptions
        $leaveTypes = [
            ['name' => 'Maternity', 'description' => 'Leave taken around the birth of a child, either before or after.'],
            ['name' => 'Paternity', 'description' => 'Leave taken by a father or partner around the time of the birth of a child.'],
            ['name' => 'Sick', 'description' => 'Leave taken when an employee is ill, for a day, weeks, or longer.'],
            ['name' => 'Annual', 'description' => 'Leave taken for vacation or personal time off from work.'],
            ['name' => 'Unpaid', 'description' => 'Leave taken without pay when other leave types are exhausted.'],
            ['name' => 'Bereavement', 'description' => 'Leave taken due to the death of a close family member.'],
            ['name' => 'Sabbatical', 'description' => 'Extended leave to pursue personal projects or rest, typically after a long service.'],
            ['name' => 'Parental', 'description' => 'Leave taken by parents to care for a newborn or newly adopted child.'],
            ['name' => 'Family Care', 'description' => 'Leave taken to care for a sick family member.'],
            ['name' => 'Study', 'description' => 'Leave taken to pursue further education or professional development.'],
            ['name' => 'Health', 'description' => 'Leave taken for health-related issues, including treatment and recovery.'],
            ['name' => 'Volunteer', 'description' => 'Leave taken to participate in volunteer activities.'],
            ['name' => 'Public Holiday', 'description' => 'Leave on official public holidays.'],
            ['name' => 'Jury Duty', 'description' => 'Leave taken to fulfill jury duty obligations.'],
            ['name' => 'Religious', 'description' => 'Leave taken to observe religious holidays or practices.'],
            ['name' => 'Election', 'description' => 'Leave taken to vote or serve as an election official.'],
            ['name' => 'Civic Duty', 'description' => 'Leave taken to fulfill civic responsibilities, such as local government duties.'],
            ['name' => 'Compassionate', 'description' => 'Leave taken to manage a serious personal or family crisis.'],
            ['name' => 'Short-Term Disability', 'description' => 'Leave taken for short-term medical conditions that prevent work.'],
            ['name' => 'Long-Term Disability', 'description' => 'Extended leave for long-term medical conditions or disabilities.']
        ];

        // Limit the number of records to the count specified or the number available, whichever is smaller
        $leaveTypesToSeed = array_slice($leaveTypes, 0, $count);

        foreach ($leaveTypesToSeed as $leaveType) {
            $name = $leaveType['name'];
            $description = $leaveType['description'];
            $minimum_period = rand(1, 30); // Assuming a random minimum period between 1 and 30 days

            // Prepare the SQL statement with placeholders
            $sql = "INSERT INTO leavetypes (name, description, minimum_period) VALUES (?, ?, ?)";
            $stmt = $this->db->getConnection()->prepare($sql);

            // Bind and execute the parameters, preventing SQL injection
            $stmt->execute([$name, $description, $minimum_period]);
        }

        $duration = round(microtime(true) - $startTime);
        echo "\033[1;32mLeave types seeded successfully! -----> {$duration}s\033[0m\n\n";
    }


    public function seedAppliedLeaves($count = 20)
    {
        $startTime = microtime(as_float: true);
        $faker = FakerFactory::create();
    
        for ($i = 0; $i < $count; $i++) {
            $applied_by = $faker->numberBetween(1, 10);
            $leavetype_id = $faker->numberBetween(1, 10);
            $description = $faker->sentence;
            $from_date = $faker->dateTimeBetween('-1 month', '+1 month')->format('Y-m-d');
            $to_date = $faker->dateTimeBetween($from_date, '+1 month')->format('Y-m-d');
            $status = $faker->randomElement(['pending', 'accepted', 'rejected']);
            $remaining_days = $status ? $faker->numberBetween(1, 10) : null;
    
            $sql = "INSERT INTO appliedleaves (applied_by, leavetype_id, description, from_date, to_date, status, remaining_days) VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt = $this->db->getConnection()->prepare($sql);
            $stmt->execute([$applied_by, $leavetype_id, $description, $from_date, $to_date, $status, $remaining_days]);
        }
    
        $duration = round(microtime(true) - $startTime);
        echo "\033[1;32mApplied leaves seeded successfully! -----> {$duration}s\033[0m\n\n";
    }
    


    // Similar methods for seeding roles, leavetypes, and appliedleaves...

    public function seedAll()
    {
        $this->seedDepartments();
        $this->seedRoles();
        $this->seedUsers();
        $this->seedLeaveTypes();
        $this->seedAppliedLeaves();
        // Seed other tables similarly...
    }
}
