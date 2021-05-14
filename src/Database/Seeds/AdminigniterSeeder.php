<?php

namespace hamkamannan\adminigniter\Database\Seeds;

use CodeIgniter\Database\Seeder;

class AdminigniterSeeder extends Seeder
{
    public function run()
    {
        $this->db->query("SET FOREIGN_KEY_CHECKS=0;");

        // Auth Groups
        $this->db->table('auth_groups')->truncate();
        $perms = [
            [
                'name' => 'admin',
                'description' => '',
            ],
            [
                'name' => 'user',
                'description' => '',
            ],
        ];
        $this->db->table('auth_groups')->insertBatch($perms);

        //Auth Users
        $this->db->table('users')->truncate();
        $perms = [
            [
                'email' => 'admin@admin.com',
                'username' => 'admin',
                'password_hash' => '$2y$10$6c5SSDEyX6HcygFqdqNZrO1KtlU7nymvkkm9rQIlzP8L.6h4n7p0a',
                'active' => '1',
                'first_name' => 'Admin',
            ],
        ];
        $this->db->table('users')->insertBatch($perms);

        //Auth Groups - Users
        $this->db->table('auth_groups_users')->truncate();
        $perms = [
            [
                'group_id' => '1',
                'user_id' => '1',
            ],
        ];
        $this->db->table('auth_groups_users')->insertBatch($perms);

        // Auth Permission
        $this->db->table('auth_permissions')->truncate();
        $perms = [
            [
                'name' => 'dashboard/access',
                'description' => '',
            ],
            [
                'name' => 'user/profile',
                'description' => '',
            ],
            [
                'name' => 'user/edit_profile',
                'description' => '',
            ],
            [
                'name' => 'user/change_password',
                'description' => '',
            ],
            [
                'name' => 'user/reset_password',
                'description' => '',
            ],
            [
                'name' => 'user/forgot_password',
                'description' => '',
            ],
        ];
        $this->db->table('auth_permissions')->insertBatch($perms);

        // Core Params
        $this->db->table('c_params')->truncate();
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
        $this->db->table('c_params')->insertBatch($params);

        // Core Menus - Categories
        $this->db->table('c_menus_categories')->truncate();
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
        $this->db->table('c_menus_categories')->insertBatch($menus_categories);

        // Core Menus - Backend
        $this->db->table('c_menus')->truncate();
        $menus_backend = [
            [
                'name' => 'Main Navigation',
                'parent' => '0',
                'controller' => 'label_menu',
                'icon' => '',
                'permission' => 'access',
                'sort' => '1',
                'type' => 'label',
                'menu_category_id' => '1',
            ],
            [
                'name' => 'Dashboard',
                'parent' => '0',
                'controller' => 'dashboard',
                'icon' => 'pe-7s-display1',
                'permission' => 'access',
                'sort' => '2',
                'type' => 'menu',
                'menu_category_id' => '1',
            ],
            [
                'name' => 'Report',
                'parent' => '0',
                'controller' => 'report',
                'icon' => 'pe-7s-graph2',
                'permission' => 'access',
                'sort' => '3',
                'type' => 'menu',
                'menu_category_id' => '1',
            ],
            [
                'name' => 'Activity Logs',
                'parent' => 3,
                'controller' => 'report/logs',
                'icon' => 'pe-7s-graph2',
                'permission' => 'access',
                'sort' => '4',
                'type' => 'menu',
                'menu_category_id' => '1',
            ],
            [
                'name' => 'Visitor Report',
                'parent' => 3,
                'controller' => 'report/visitors',
                'icon' => 'pe-7s-graph2',
                'permission' => 'access',
                'sort' => '5',
                'type' => 'menu',
                'menu_category_id' => '1',
            ],
            [
                'name' => 'User Management',
                'parent' => '0',
                'controller' => 'home',
                'icon' => 'pe-7s-user',
                'permission' => 'access',
                'sort' => '6',
                'type' => 'menu',
                'menu_category_id' => '1',
            ],
            [
                'name' => 'Users',
                'parent' => '6',
                'controller' => 'user',
                'icon' => 'pe-7s-user',
                'permission' => 'access|create|read|update|delete|enable|disable',
                'sort' => '7',
                'type' => 'menu',
                'menu_category_id' => '1',
            ],
            [
                'name' => 'Roles',
                'parent' => '6',
                'controller' => 'group',
                'icon' => 'pe-7s-users',
                'permission' => 'access|create|read|update|delete|enable|disable',
                'sort' => '8',
                'type' => 'menu',
                'menu_category_id' => '1',
            ],
            [
                'name' => 'Permissions',
                'parent' => '6',
                'controller' => 'permission',
                'icon' => 'pe-7s-shield',
                'permission' => 'access|create|read|update|delete|enable|disable',
                'sort' => '9',
                'type' => 'menu',
                'menu_category_id' => '1',
            ],
            [
                'name' => 'Access',
                'parent' => '6',
                'controller' => 'access',
                'icon' => 'pe-7s-unlock',
                'permission' => 'access|create|read|update|delete|enable|disable',
                'sort' => '10',
                'type' => 'menu',
                'menu_category_id' => '1',
            ],
            [
                'name' => 'Menu',
                'parent' => '6',
                'controller' => 'menu',
                'icon' => 'pe-7s-menu',
                'permission' => 'access|create|read|update|delete|enable|disable',
                'sort' => '11',
                'type' => 'menu',
                'menu_category_id' => '1',
            ],
            [
                'name' => 'Setting',
                'parent' => '0',
                'controller' => '#',
                'icon' => 'pe-7s-config',
                'permission' => 'access|create|read|update|delete',
                'sort' => '12',
                'type' => 'menu',
                'menu_category_id' => '1',
            ],
            [
                'name' => 'Parameter',
                'parent' => 12,
                'controller' => 'param',
                'icon' => '',
                'permission' => 'access',
                'sort' => '13',
                'type' => 'menu',
                'menu_category_id' => '1',
            ],
            [
                'name' => 'Reference',
                'parent' => 12,
                'controller' => 'reference',
                'icon' => '',
                'permission' => 'access',
                'sort' => '14',
                'type' => 'menu',
                'menu_category_id' => '1',
            ],
        ];
        $this->db->table('c_menus')->insertBatch($menus_backend);

        // Core Menus - Frontend
        $menus_reference = [
            [
                'name' => 'Home',
                'parent' => '0',
                'controller' => 'home',
                'icon' => '',
                'permission' => 'access',
                'sort' => '16',
                'type' => 'menu',
                'menu_category_id' => '2',
            ],
        ];
        $this->db->table('c_menus')->insertBatch($menus_reference);

        // Core Menus - Reference
        $menus_reference = [
            [
                'name' => 'Permission',
                'parent' => '0',
                'controller' => 'reference_permission',
                'icon' => '',
                'permission' => 'access',
                'sort' => '17',
                'type' => 'menu',
                'menu_category_id' => '3',
            ],
        ];
        $this->db->table('c_menus')->insertBatch($menus_reference);

        // Core References
        $this->db->table('c_references')->truncate();
        $references = [
            [
                'name' => 'access',
                'slug' => 'access',
                'sort' => '1',
                'menu_id' => '17'
            ],
            [
                'name' => 'create',
                'slug' => 'create',
                'sort' => '2',
                'menu_id' => '17'
            ],
            [
                'name' => 'read',
                'slug' => 'read',
                'sort' => '3',
                'menu_id' => '17'
            ],
            [
                'name' => 'update',
                'slug' => 'update',
                'sort' => '4',
                'menu_id' => '17'
            ],
            [
                'name' => 'delete',
                'slug' => 'delete',
                'sort' => '5',
                'menu_id' => '17'
            ],
            [
                'name' => 'enable',
                'slug' => 'enable',
                'sort' => '6',
                'menu_id' => '17'
            ],
            [
                'name' => 'disable',
                'slug' => 'disable',
                'sort' => '7',
                'menu_id' => '17'
            ],  
        ];
        $this->db->table('c_references')->insertBatch($references);

        $this->db->query("SET FOREIGN_KEY_CHECKS=1;");
    }
}
