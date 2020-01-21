<?php
/**
 * Plugin Name:     React Router Wordpress Admin Plugin Demo
 * Description:     A plugin scaffolded with Shamrock ☘
 * Version:         0.1.0
 * Author:          Nathan Knowler
 * Author URI:      https://knowlerkno.ws
 * License:         MIT License
 * Text Domain:     react-router-wordpress-admin-plugin-demo
 *
 * Requires PHP 7+
 */

/** Require those Composer dependencies */
require(__DIR__.'/vendor/autoload.php');

use Illuminate\Support\Str;

/** Create the plugin */
$plugin = new class {
    public function __construct()
    {
        $this->pages = [
            (object) [
                'title' => __('Demo', 'react-router-wordpress-admin-plugin-demo'),
                'path' => 'demo',
            ],
            (object) [
                'title' => __('Options', 'react-router-wordpress-admin-plugin-demo'),
                'path' => 'demo#/options',
            ],
        ];
    }

    public function run()
    {
        add_action('admin_menu', [$this, 'addAdminMenu']);
        add_action('admin_enqueue_scripts', [$this, 'enqueueAdminScripts']);
    }

    public function addAdminMenu()
    {
        foreach($this->pages as $index => $page) {
            if ($index === 0) {
                add_menu_page(
                    $page->title,
                    $page->title,
                    'manage_options',
                    $page->path,
                    [$this, 'renderReactRoot']
                );
            } else {
                add_submenu_page(
                    'demo',
                    $page->title,
                    $page->title,
                    'manage_options',
                    $page->path,
                    [$this, 'renderReactRoot']
                );
            }
        }
    }

    public function enqueueAdminScripts()
    {
        wp_enqueue_script('demo', plugin_dir_url(__FILE__) . 'dist/main.js', null, null, true);
        wp_localize_script('demo', 'DEMO', (object) [
            'pages' => array_map(function ($page) {
                if ($page->path === 'demo') {
                    return (object) [
                        'path' => '/',
                        'title' => $page->title,
                    ];
                }

                if (Str::startsWith($page->path, 'demo#/')) {
                    return (object) [
                        'path' => Str::after($page->path, 'demo#'),
                        'title' => $page->title,
                    ];
                }

                return null;
            }, $this->pages),
        ]);
    }

    public function renderReactRoot()
    {
        echo '<div id="root"></div>';
    }
};

/** Run the plugin */
$plugin->run();
