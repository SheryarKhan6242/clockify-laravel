<?php

return [
    [
        'route'     => 'department.index',
        'label'     => 'Departments',
        'name'      => 'departments',
        'icon'      => 'feather-icon',
    ],
    [
        'route'     => 'shift.index',
        'label'     => 'Shifts',
        'name'      => 'shifts',
        'icon'      => 'feather-icon',
    ],
    [
        'route'     => 'location.index',
        'label'     => 'Locations',
        'name'      => 'locations',
        'icon'      => 'feather-icon',
    ],
    [
        'route'     => '#',
        'label'     => 'Employees',
        'name'      => 'employees',
        'icon'      => 'feather-icon',
        'sub-menu'  => [
            [
                'route' => 'emp.index',
                'label' => 'Manage Employees',
                'name'  => 'employees',
                'icon'  => 'feather-icon',
            ],
            [
                'route' => 'emp.type.index',
                'label' => 'Employee Type',
                'name'  => 'emp-type',
                'icon'  => 'feather-icon',
            ],
            [   'route' => 'emp.type.index',
                'label' => 'Leaves',
                'name'  => 'leaves',
                'icon'  => 'feather-icon',
            ],
        ]
    ],
    [
        'route'     => 'leaveType.index',
        'label'     => 'Leave Types',
        'name'      => 'Leave Types',
        'icon'      => 'feather-icon',
    ],
    [
        'route'     => 'workType.index',
        'label'     => 'Work Types',
        'name'      => 'Work Types',
        'icon'      => 'feather-icon',
    ],
];
