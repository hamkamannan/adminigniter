<?php

namespace hamkamannan\adminigniterDatabase\Seeds;

use CodeIgniter\Database\Seeder;

class AdminigniterSeeder extends Seeder
{
    public function run()
    {
        $this->db->table('auth_permissions')->emptyTable();
        // $this->db->table('auth_permissions')->truncate();
        $perms = [
            [
                'name' => 'dashboard/access',
                'description' => '',
            ],
            [
                'name' => 'auth/view_profile',
                'description' => '',
            ],
            [
                'name' => 'auth/edit_profile',
                'description' => '',
            ],
            [
                'name' => 'auth/change_password',
                'description' => '',
            ],
            [
                'name' => 'auth/reset_password',
                'description' => '',
            ],
            [
                'name' => 'auth/forgot_password',
                'description' => '',
            ],
            [
                'name' => 'auth/register',
                'description' => '',
            ],
        ];
        $this->db->table('auth_permissions')->insertBatch($perms);

        $params = [
            [
                'name' => 'timezone',
                'value' => 'Asia/Jakarta',
                'description' => '',
            ],
            [
                'name' => 'site-name',
                'value' => 'Adminigniter',
                'description' => '',
            ],
            [
                'name' => 'site-description',
                'value' => 'Adminigniter',
                'description' => '',
            ],
            [
                'name' => 'site-visitor-mode',
                'value' => '1',
                'description' => '0 = Read from Param site-visitor | 1 = Calculate by IP',
            ],
            [
                'name' => 'site-visitor',
                'value' => '50',
                'description' => '',
            ],
            [
                'name' => 'site-copyright',
                'value' => '&copy; 2021 Adminigniter',
                'description' => '',
            ],
            [
                'name' => 'author',
                'value' => 'Hamka Mannan',
                'description' => '',
            ],
            [
                'name' => 'logo',
                'value' => '/uploads/logo.png',
                'description' => '',
            ],
            [
                'name' => 'logo-small',
                'value' => '/uploads/logo-small.png',
                'description' => '',
            ],
            [
                'name' => 'logo-inverse',
                'value' => '/uploads/logo-inverse.png',
                'description' => '',
            ],
            [
                'name' => 'favicon',
                'value' => '/uploads/favicon.png',
                'description' => '',
            ],
            [
                'name' => 'sidebar-mode',
                'value' => 'auto',
                'description' => 'auto = from database | manual = from file',
            ],
            [
                'name' => 'topbar-mode',
                'value' => 'auto',
                'description' => 'auto = from database | manual = from file',
            ],
            [
                'name' => 'sidebar-file',
                'value' => 'hamkamannan\adminigniter\layout\backend\partial\navigation',
                'description' => 'file path without extention .php',
            ],
            [
                'name' => 'topbar-file',
                'value' => 'hamkamannan\adminigniter\layout\frontend\partial\navigation',
                'description' => 'file path without extention .php',
            ],
            [
                'name' => 'show-logo-login',
                'value' => '1',
                'description' => '1 = show | 0 = hide means show site name',
            ],
            [
                'name' => 'show-logo-sidebar',
                'value' => '0',
                'description' => '1 = show | 0 = hide means show site name',
            ],
            [
                'name' => 'show-top-checkbox',
                'value' => '0',
                'description' => '1 = show | 0 = hide for top checkbox',
            ],
            [
                'name' => 'show-layout-setting',
                'value' => '0',
                'description' => '1 = show | 0 = hide for floating bottom right icon',
            ],
            [
                'name' => 'show-banner-intro',
                'value' => '1',
                'description' => '1 = show | 0 = hide for banner intro',
            ],
            [
                'name' => 'logo-cs-class',
                'value' => 'bg-night-sky',
                'description' => 'bg-primary|bg-success|bg-warning|bg-danger|bg-royalbg-slick-carbon|bg-focus|bg-dark|bg-light',
            ],
            [
                'name' => 'header-cs-class',
                'value' => 'bg-primary header-text-light',
                'description' => 'background and text',
            ],
            [
                'name' => 'sidebar-cs-class',
                'value' => 'bg-night-sky sidebar-text-light',
                'description' => 'background and text',
            ],
            [
                'name' => 'container-header-class',
                'value' => 'fixed-header',
                'description' => 'fixed-header',
            ],
            [
                'name' => 'container-sidebar-class',
                'value' => 'fixed-sidebar',
                'description' => 'fixed-sidebar',
            ],
            [
                'name' => 'container-footer-class',
                'value' => '',
                'description' => 'fixed-footer',
            ],
            [
                'name' => 'contact_initial',
                'value' => 'Adminigniter',
                'description' => '',
            ],
            [
                'name' => 'contact-name',
                'value' => 'Adminigniter',
                'description' => '',
            ],
            [
                'name' => 'contact-phone',
                'value' => '082172766354',
                'description' => '',
            ],
            [
                'name' => 'contact-email',
                'value' => 'info@adminigniter.com',
                'description' => '',
            ],
            [
                'name' => 'contact-facebook',
                'value' => 'Adminigniter',
                'description' => '',
            ],
            [
                'name' => 'contact-facebook-url',
                'value' => 'https://facebook.com/',
                'description' => '',
            ],
            [
                'name' => 'contact-instagram',
                'value' => '@adminigniter',
                'description' => '',
            ],
            [
                'name' => 'contact-instagram-url',
                'value' => 'https://instagram.com/',
                'description' => '',
            ],
            [
                'name' => 'contact-youtube',
                'value' => 'adminigniter',
                'description' => '',
            ],
            [
                'name' => 'contact-youtube-url',
                'value' => 'https://youtube.com/',
                'description' => '',
            ],
            [
                'name' => 'contact-twitter',
                'value' => '@adminigniter',
                'description' => '',
            ],
            [
                'name' => 'contact-twitter-url',
                'value' => 'https://twitter.com/',
                'description' => '',
            ],
            [
                'name' => 'limit-banner',
                'value' => '3',
                'description' => '',
            ],
        ];
        $this->db->table('c_params')->truncate();
        $this->db->table('c_params')->insertBatch($params);

        $menus_categories = [
            [
                'name' => 'Backend Menu',
                'slug' => 'backend-menu',
                'sort' => '1',
            ],
            [
                'name' => 'Frontend Menu',
                'slug' => 'frontend-menu',
                'sort' => '2',
            ],
            [
                'name' => 'Reference Menu',
                'slug' => 'reference-menu',
                'sort' => '3',
            ],
        ];

        $this->db->table('c_menus_categories')->truncate();
        $this->db->table('c_menus_categories')->insertBatch($menus_categories);

        $this->db->table('c_menus')->truncate();

        $menus_backend = [
            [
                'name' => 'Menu',
                'parent' => null,
                'controller' => 'label_menu',
                'icon' => '',
                'permission' => 'access',
                'sort' => '1',
                'type' => 'label',
                'menu_category_id' => '1',
            ],
            [
                'name' => 'Dashboard',
                'parent' => null,
                'controller' => 'dashboard',
                'icon' => 'pe-7s-display1',
                'permission' => 'access',
                'sort' => '2',
                'type' => 'menu',
                'menu_category_id' => '1',
            ],
            [
                'name' => 'Laporan',
                'parent' => null,
                'controller' => 'report',
                'icon' => 'pe-7s-graph2',
                'permission' => 'access',
                'sort' => '3',
                'type' => 'menu',
                'menu_category_id' => '1',
            ],
            [
                'name' => 'Aktivitas',
                'parent' => 3,
                'controller' => 'report/logs',
                'icon' => 'pe-7s-graph2',
                'permission' => 'access',
                'sort' => '4',
                'type' => 'menu',
                'menu_category_id' => '1',
            ],
            [
                'name' => 'Kunjungan',
                'parent' => 3,
                'controller' => 'report/visitors',
                'icon' => 'pe-7s-graph2',
                'permission' => 'access',
                'sort' => '5',
                'type' => 'menu',
                'menu_category_id' => '1',
            ],
            [
                'name' => 'Admin',
                'parent' => null,
                'controller' => 'label_admin',
                'icon' => '',
                'permission' => 'access',
                'sort' => '6',
                'type' => 'label',
                'menu_category_id' => '1',
            ],
            [
                'name' => 'User Management',
                'parent' => null,
                'controller' => 'home',
                'icon' => 'pe-7s-user',
                'permission' => 'access',
                'sort' => '7',
                'type' => 'menu',
                'menu_category_id' => '1',
            ],
            [
                'name' => 'Users',
                'parent' => '7',
                'controller' => 'user',
                'icon' => 'pe-7s-user',
                'permission' => 'access|create|read|update|delete|enable|disable',
                'sort' => '8',
                'type' => 'menu',
                'menu_category_id' => '1',
            ],
            [
                'name' => 'Roles',
                'parent' => '7',
                'controller' => 'group',
                'icon' => 'pe-7s-users',
                'permission' => 'access|create|read|update|delete|enable|disable',
                'sort' => '9',
                'type' => 'menu',
                'menu_category_id' => '1',
            ],
            [
                'name' => 'Permissions',
                'parent' => '7',
                'controller' => 'permission',
                'icon' => 'pe-7s-shield',
                'permission' => 'access|create|read|update|delete|enable|disable',
                'sort' => '10',
                'type' => 'menu',
                'menu_category_id' => '1',
            ],
            [
                'name' => 'Access',
                'parent' => '7',
                'controller' => 'access',
                'icon' => 'pe-7s-unlock',
                'permission' => 'access|create|read|update|delete|enable|disable',
                'sort' => '11',
                'type' => 'menu',
                'menu_category_id' => '1',
            ],
            [
                'name' => 'Menu',
                'parent' => '7',
                'controller' => 'menu',
                'icon' => 'pe-7s-menu',
                'permission' => 'access|create|read|update|delete|enable|disable',
                'sort' => '12',
                'type' => 'menu',
                'menu_category_id' => '1',
            ],
            [
                'name' => 'Setting',
                'parent' => null,
                'controller' => '#',
                'icon' => 'pe-7s-config',
                'permission' => 'access|create|read|update|delete',
                'sort' => '13',
                'type' => 'menu',
                'menu_category_id' => '1',
            ],
            [
                'name' => 'Parameter',
                'parent' => 13,
                'controller' => 'param',
                'icon' => '',
                'permission' => 'access',
                'sort' => '14',
                'type' => 'menu',
                'menu_category_id' => '1',
            ],
            [
                'name' => 'Referensi',
                'parent' => 13,
                'controller' => 'param',
                'icon' => '',
                'permission' => 'access',
                'sort' => '15',
                'type' => 'menu',
                'menu_category_id' => '1',
            ],
        ];
        $this->db->table('c_menus')->insertBatch($menus_backend);

    }
}
