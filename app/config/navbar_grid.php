<?php
/**
 * Config-file for navigation bar.
 *
 */
return [

    // Use for styling the menu
    'class' => 'navbar',
 
    // Here comes the menu strcture
    'items' => [

        // This is a menu item
        'home'  => [
            'text'  => 'Hem',   
            'url'   => '',  
            'title' => 'Me',
            'icon'  => 'fa fa-home fa-fw',
        ],
 
        // This is a menu item
        'report'  => [
            'text'  => 'Redovisning',   
            'url'   => 'report',   
            'title' => 'Redovisning',
            'icon'  => 'fa fa-book fa-fw',
        ],
 
        // This is a menu item
        'source' => [
            'text'  => 'Källkod', 
            'url'   => 'source',  
            'title' => 'Källkod',
            'icon'  => 'fa fa-pencil fa-fw',
        ],

        'newTheme' => [
            'text'  => 'Test av tema',
            'url'   => 'newTheme/square-net',
            'title' => 'Test av tema',
            'icon'  => 'fa fa-wrench fa-fw',

            'submenu' => [

                'items' => [

                    // This is a menu item of the submenu
                    'square-net'  => [
                        'text'  => 'Rutnät',   
                        'url'   => 'newTheme/square-net',  
                        'title' => 'Rutnät'
                    ],

                    // This is a menu item of the submenu
                    'regioner'  => [
                        'text'  => 'Regioner',   
                        'url'   => 'newTheme/regions',  
                        'title' => 'Regioner'
                    ],

                    // This is a menu item of the submenu
                    'fonts'  => [
                        'text'  => 'Fonter',   
                        'url'   => 'newTheme/fonts',  
                        'title' => 'Fonter'
                    ],
                ],
            ],
        ],

        'users' => [
            'text'  => 'Användare',
            'url'   => 'users.php',
            'title' => 'Användare',
            'icon'  => 'fa fa-users fa-fw'
        ],
    ],
 
    // Callback tracing the current selected menu item base on scriptname
    'callback' => function($url) {
        if ($url == $this->di->get('request')->getRoute()) {
            return true;
        }
    },

    // Callback to create the urls
    'create_url' => function($url) {
        return $this->di->get('url')->create($url);
    },
];
