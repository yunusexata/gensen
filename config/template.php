<?php

return [
    'title' => env('APP_NAME', 'Template Project'),
    'subtitle' => 'Software House',

    'logo_auth' => 'files/images/logo.svg',
    'logo_auth_background' => 'white',

    'logo_panel' => 'files/images/logo_long.svg',
    'logo_panel_background' => 'white',

    'registration_route' => 'register',
    'registration_default_role' => 'Member',

    'forgot_password_route' => 'password.request',
    'reset_password_route' => 'password.reset',

    // 'email_verification_route' => 'verification.index',
    'email_verification_route' => '',
    'email_verification_delay_time' => 30,

    'email_verify_route' => 'verification.verify',

    'profile_route' => 'profile',
    'profile_image' => 'assets/media/avatars/profile.png',

    'menu' => [
        [
            'text' => 'Data Gensen',
            'route'  => 'gensen_data.index',
            'icon' => 'ki-duotone ki-element-11',
        ],
        [
            'text' => 'Buat Link',
            'route'  => 'gensen_form_link.index',
            'icon' => 'ki-duotone ki-element-11',
        ],
        [
            'text' => 'Export Import',
            'route'  => 'gensen_form_export_import.index',
            'icon' => 'ki-duotone ki-element-11',
        ],
        // [
        //     'text' => 'Pengganti Buku Nenkin',
        //     'route'  => 'buku_nenkin.index',
        //     'icon' => 'ki-duotone ki-element-11',
        // ],
        [
            // 'id' => 'menu_admin'
            'text' => 'Extraction Dokumen',
            'icon' => 'ki-duotone ki-shield-tick',
            'submenu' => [
                [
                    'text' => 'Ichijikin Extraction',
                    'route' => 'ichijikin_extraction.index',
                    'icon_color' => 'success',
                ],
                // [
                //     'text' => 'Resi Generator',
                //     'route' => 'resi_generator.index',
                //     'icon_color' => 'success',
                // ],
            ],
        ],
        [
            // 'id' => 'menu_admin'
            'text' => 'Admin',
            'icon' => 'ki-duotone ki-shield-tick',
            'submenu' => [
                [
                    'text' => 'Pengguna',
                    'route' => 'user.index',
                    'icon_color' => 'success',
                ],
                [
                    'text' => 'Jabatan',
                    'route' => 'role.index',
                    'icon_color' => 'primary',
                ],
                [
                    'text' => 'Akses',
                    'route' => 'permission.index',
                    'icon_color' => 'primary',
                ],
            ],
        ],
    ],
];
