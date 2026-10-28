<?php
// Single source of truth for dashboard navigation. Each entry lists the roles allowed to see it.
return [
    ['label' => 'Dashboard',      'icon' => 'bi bi-columns-gap',        'path' => 'dashboard',     'roles' => ['admin', 'employee']],
    ['label' => 'Employees',      'icon' => 'fas fa-users',             'path' => 'employees',     'roles' => ['admin']],
    ['label' => 'Departments',    'icon' => 'bi bi-diagram-3-fill',     'path' => 'departments',   'roles' => ['admin']],
    ['label' => 'Department',     'icon' => 'bi bi-building-check',     'path' => 'department',    'roles' => ['employee']],
    ['label' => 'Applied Leaves', 'icon' => 'bi bi-person-fill-check',  'path' => 'appliedleaves', 'roles' => ['admin', 'employee']],
    ['label' => 'Leave Types',    'icon' => 'bi bi-list-ol',            'path' => 'leavetypes',    'roles' => ['admin', 'employee']],
];
