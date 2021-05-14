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
                'value' => 'Kepustakaan Kowani',
                'description' => '',
            ],
            [
                'name' => 'site-description',
                'value' => 'Kepustakaan Kongres Wanita Indonesia',
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
                'value' => '&copy; 2021 Kepustakaan Kongres Wanita Indonesia',
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
                'value' => 'hamkamannan\adminigniter\layout\backend\partialnavigation',
                'description' => 'file path without extention .php',
            ],
            [
                'name' => 'topbar-file',
                'value' => 'layout/frontend/partial/navigation',
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
                'value' => 'Kepustakaan Kowani',
                'description' => '',
            ],
            [
                'name' => 'contact-name',
                'value' => 'Kepustakaan Kowani',
                'description' => '',
            ],
            [
                'name' => 'contact-phone',
                'value' => '082172766354',
                'description' => '',
            ],
            [
                'name' => 'contact-email',
                'value' => 'info@perpusbunghatta.com',
                'description' => '',
            ],
            [
                'name' => 'contact-facebook',
                'value' => 'Kepustakaan Kowani',
                'description' => '',
            ],
            [
                'name' => 'contact-facebook-url',
                'value' => 'https://facebook.com/',
                'description' => '',
            ],
            [
                'name' => 'contact-instagram',
                'value' => '@uptbunghatta',
                'description' => '',
            ],
            [
                'name' => 'contact-instagram-url',
                'value' => 'https://instagram.com/',
                'description' => '',
            ],
            [
                'name' => 'contact-youtube',
                'value' => 'Kepustakaan Kowani',
                'description' => '',
            ],
            [
                'name' => 'contact-youtube-url',
                'value' => 'https://youtube.com/',
                'description' => '',
            ],
            [
                'name' => 'contact-twitter',
                'value' => '@UPTBungHatta',
                'description' => '',
            ],
            [
                'name' => 'contact-twitter-url',
                'value' => 'https://twitter.com/',
                'description' => '',
            ],
            [
                'name' => 'limit-banner',
                'value' => '10',
                'description' => '',
            ],
            [
                'name' => 'limit-blog',
                'value' => '3',
                'description' => '',
            ],
            [
                'name' => 'limit-announcement',
                'value' => '3',
                'description' => '',
            ],
            [
                'name' => 'limit-event',
                'value' => '2',
                'description' => '',
            ],
            [
                'name' => 'limit-testimonial',
                'value' => '6',
                'description' => '',
            ],
            [
                'name' => 'limit-media',
                'value' => '3',
                'description' => '',
            ],

        ];
        $this->db->table('c_params')->truncate();
        $this->db->table('c_params')->insertBatch($params);

        $menus_categories = [
            [
                'name' => 'Side Menu',
                'slug' => 'side-menu',
                'sort' => '1',
            ],
            [
                'name' => 'Top Menu',
                'slug' => 'top-menu',
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
                'name' => 'Tokoh Wanita',
                'parent' => null,
                'controller' => 'figure',
                'icon' => 'pe-7s-display2',
                'permission' => 'access|create|read|update|delete',
                'sort' => '3',
                'type' => 'menu',
                'menu_category_id' => '1',
            ],
            [
                'name' => 'Penulis Wanita',
                'parent' => null,
                'controller' => 'author',
                'icon' => 'pe-7s-volume',
                'permission' => 'access|create|read|update|delete',
                'sort' => '4',
                'type' => 'menu',
                'menu_category_id' => '1',
            ],
            [
                'name' => 'Koleksi Buku Wanita',
                'parent' => null,
                'controller' => 'book',
                'icon' => 'pe-7s-date',
                'permission' => 'access|create|read|update|delete',
                'sort' => '5',
                'type' => 'menu',
                'menu_category_id' => '1',
            ],
            [
                'name' => 'Artikel Wanita',
                'parent' => null,
                'controller' => 'article',
                'icon' => 'pe-7s-date',
                'permission' => 'access|create|read|update|delete',
                'sort' => '6',
                'type' => 'menu',
                'menu_category_id' => '1',
            ],
            [
                'name' => 'Penelitian Wanita',
                'parent' => null,
                'controller' => 'research',
                'icon' => 'pe-7s-date',
                'permission' => 'access|create|read|update|delete',
                'sort' => '7',
                'type' => 'menu',
                'menu_category_id' => '1',
            ],
            [
                'name' => 'Wanita Dalam Gambar',
                'parent' => null,
                'controller' => 'picture',
                'icon' => 'pe-7s-date',
                'permission' => 'access|create|read|update|delete',
                'sort' => '7',
                'type' => 'menu',
                'menu_category_id' => '1',
            ],
            [
                'name' => 'Wanita Dalam Rekaman',
                'parent' => null,
                'controller' => 'record',
                'icon' => 'pe-7s-date',
                'permission' => 'access|create|read|update|delete',
                'sort' => '7',
                'type' => 'menu',
                'menu_category_id' => '1',
            ],
            [
                'name' => 'Banner',
                'parent' => null,
                'controller' => 'banner',
                'icon' => 'pe-7s-photo',
                'permission' => 'access|create|read|update|delete',
                'sort' => '8',
                'type' => 'menu',
                'menu_category_id' => '1',
            ],
            [
                'name' => 'FAQ',
                'parent' => null,
                'controller' => 'faq',
                'icon' => 'pe-7s-study',
                'permission' => 'access|create|read|update|delete',
                'sort' => '9',
                'type' => 'menu',
                'menu_category_id' => '1',
            ],
            [
                'name' => 'Testimoni',
                'parent' => null,
                'controller' => 'testimonial',
                'icon' => 'pe-7s-comment',
                'permission' => 'access|create|read|update|delete',
                'sort' => '10',
                'type' => 'menu',
                'menu_category_id' => '1',
            ],
            [
                'name' => 'Kontak',
                'parent' => null,
                'controller' => 'contact',
                'icon' => 'pe-7s-id',
                'permission' => 'access|create|read|update|delete',
                'sort' => '11',
                'type' => 'menu',
                'menu_category_id' => '1',
            ],
            [
                'name' => 'Laporan',
                'parent' => null,
                'controller' => 'report',
                'icon' => 'pe-7s-graph2',
                'permission' => 'access',
                'sort' => '12',
                'type' => 'menu',
                'menu_category_id' => '1',
            ],
            [
                'name' => 'Laporan Kunjungan',
                'parent' => 12,
                'controller' => 'report/visitors',
                'icon' => 'pe-7s-graph2',
                'permission' => 'access',
                'sort' => '21',
                'type' => 'menu',
                'menu_category_id' => '1',
            ],
            [
                'name' => 'Admin',
                'parent' => null,
                'controller' => 'label_admin',
                'icon' => '',
                'permission' => 'access',
                'sort' => '13',
                'type' => 'label',
                'menu_category_id' => '1',
            ],
            [
                'name' => 'User',
                'parent' => null,
                'controller' => 'user',
                'icon' => 'pe-7s-user',
                'permission' => 'access|create|read|update|delete|enable|disable',
                'sort' => '14',
                'type' => 'menu',
                'menu_category_id' => '1',
            ],
            [
                'name' => 'Group',
                'parent' => null,
                'controller' => 'group',
                'icon' => 'pe-7s-users',
                'permission' => 'access|create|read|update|delete|enable|disable',
                'sort' => '15',
                'type' => 'menu',
                'menu_category_id' => '1',
            ],
            [
                'name' => 'Menu',
                'parent' => null,
                'controller' => 'menu',
                'icon' => 'pe-7s-menu',
                'permission' => 'access|create|read|update|delete|enable|disable',
                'sort' => '16',
                'type' => 'menu',
                'menu_category_id' => '1',
            ],
            [
                'name' => '1',
                'parent' => '16',
                'controller' => 'menu?category=backend',
                'icon' => '',
                'permission' => 'access',
                'sort' => '17',
                'type' => 'menu',
                'menu_category_id' => '1',
            ],
            [
                'name' => '2',
                'parent' => '16',
                'controller' => 'menu?category=frontend',
                'icon' => '',
                'permission' => 'access',
                'sort' => '18',
                'type' => 'menu',
                'menu_category_id' => '1',
            ],
            [
                'name' => 'Setting',
                'parent' => null,
                'controller' => 'param',
                'icon' => 'pe-7s-config',
                'permission' => 'access|create|read|update|delete',
                'sort' => '19',
                'type' => 'menu',
                'menu_category_id' => '1',
            ],
            [
                'name' => 'Parameter',
                'parent' => 19,
                'controller' => 'param',
                'icon' => '',
                'permission' => 'access',
                'sort' => '20',
                'type' => 'menu',
                'menu_category_id' => '1',
            ],
        ];
        $this->db->table('c_menus')->insertBatch($menus_backend);

    }
}
