# Leave Management System 
A Full-Stack web application built on top of PHP(OOP), MySQL(PDO), jQuery and Bootstrap css. It consists of Home page, Admin Panel and Employee panel for management. It runs on MVC structure.

## set up

* Clone this repository then make a copy of database_sample.php to database.php located on src/database_sample.php using command below then fill in your database credentials.


```bash
cp src/database_sample.php src/database.php
```

Fill your db connection credentials 


```bash
        'servername' => DB username,
        'database' => Database name,
        'username' => DB username,
        'password' => DB password,
```


! For SMTP for registering account and resetting password

```bash
cp src/database_sample.php src/smtp_conf.php
```

Fill your SMTP credentials 


```bash
        'host' => 'smtp.gma...',
        'from' => 'smtpmail',
        'username' => 'smtpmail',
        'password' => 'smtp_password',
```

* Install necessary dependencies and dump the classess for auto load.


```bash
composer install && composer dump-autoload
```

* Let's jumpstart db by migration and seed all together to create our tables and add dummy data.

! Start with creating blueprints of our db - it will create necessary tables and structure for this leave manager just keep inputing y on your terminal or just click enter anytime asked.


```bash
php migration.php
```

! Its time to seed or add dummy data to use straight away we start our application. keep clicking enter whenever asked.


```bash
php seed.php
```

* Now Start the server at your favorite port using built in php cli - On your browser at the url `http://localhost:8088/`

```bash
php -S localhost:8088
```

## usage

- We have landing page, admin panel and Employee panel 
- To login as admin use email and password below

```bash
admin@gmail.com - password123
```
- To login as employee use email and password below

```bash
employee@gmail.com - password123
```

## Features

- Structured Home page for informative information including frequently asked question, about, contact, register, login and reset password.
- Admin can manage the whole organization resources by 
 * Adding Users, Departments, Leave Types etc
 * Updates Applied leaves(Approves,Dissaproves)
 * Managing User accounts
- Employee on the other side does the following
 * Applies the leave
 * Checks the status of the application
 * Checks the department he/she belongs to, all leavetypes and their description
 * Managing their accounts 

### Database Design
<img width="auto" alt="Database Design" src="https://github.com/ronald-kimeli/leave-management-php/blob/latest_oop/public/images/database_design.png">

### Home Page
<img width="auto" alt="Home Page" src="https://github.com/ronald-kimeli/leave-management-php/blob/latest_oop/public/images/home.png">

### Login
<img width="auto" alt="Login" src="https://github.com/ronald-kimeli/leave-management-php/blob/latest_oop/public/images/login.png">

### Admin Applied Leaves
<img width="auto" alt="Leaves" src="https://github.com/ronald-kimeli/leave-management-php/blob/latest_oop/public/images/applied_admin.png">

### Employee Applied Leaves
<img width="auto" alt="Leaves" src="https://github.com/ronald-kimeli/leave-management-php/blob/latest_oop/public/images/employee_apply_leave.png">

### Mobile Responsive
<img width="auto" alt="Leaves" src="https://github.com/ronald-kimeli/leave-management-php/blob/latest_oop/public/images/mobile_responsive.png">





