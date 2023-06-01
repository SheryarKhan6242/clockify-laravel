<?php

return [
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
            [
                'route'     => 'workType.index',
                'label'     => 'Work Type',
                'name'      => 'Work Type',
                'icon'      => 'feather-icon',
            ],
        ]
    ],
    [
        'route'     => 'report.index',
        'label'     => 'Departments',
        'name'      => 'departments',
        'icon'      => 'feather-icon',
    ],
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
        'label'     => 'Leaves',
        'name'      => 'leaves',
        'icon'      => 'feather-icon',
        'sub-menu'  => [
            [
                'route'     => 'leave.index',
                'label'     => 'Managae Leaves',
                'name'      => 'Managae Leaves',
                'icon'      => 'feather-icon',
            ],
            [
                'route'     => 'leaveType.index',
                'label'     => 'Leave Types',
                'name'      => 'Leave Types',
                'icon'      => 'feather-icon',
            ],
        ]
    ],
    [
        'route'     => 'wfh.index',
        'label'     => 'Work From Home',
        'name'      => 'Work From Home',
        'icon'      => 'feather-icon',
    ],
    [
        'route'     => 'notice.index',
        'label'     => 'Notices',
        'name'      => 'Notices',
        'icon'      => 'feather-icon',
    ],
    [
        'route'     => 'holiday.index',
        'label'     => 'Holidays',
        'name'      => 'Holidays',
        'icon'      => 'feather-icon',
    ],
    [
        'route'     => 'event.index',
        'label'     => 'Events',
        'name'      => 'Events',
        'icon'      => 'feather-icon',
    ],
    [
        'route'     => '#',
        'label'     => 'Settings',
        'name'      => 'Settings',
        'icon'      => 'feather-icon',
        'sub-menu'  => [
            [
                'route'     => 'template.index',
                'label'     => 'Email Template',
                'name'      => 'Email Template',
                'icon'      => 'feather-icon',
            ],
        ]
    ],
];
