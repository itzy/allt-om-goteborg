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
            'title' => 'Hem',
            'icon'  => 'fa fa-home fa-fw',
        ],
 
        // This is a menu item
        'questions'  => [
            'text'  => 'Frågor',   
            'url'   => 'question/listAll',   
            'title' => 'Frågor',
            'icon'  => 'fa fa-question fa-fw',
        ],
 
        // This is a menu item
        'tags' => [
            'text'  => 'Taggar', 
            'url'   => 'tag/list',  
            'title' => 'Taggar',
            'icon'  => 'fa fa-quote-right fa-fw',
        ],

        'users' => [
            'text'  => 'Användare',
            'url'   => 'users/list',
            'title' => 'Användare',
            'icon'  => 'fa fa-users fa-fw',
        ],
        'about' => [
            'text'  => 'Om oss',
            'url'   => 'about',
            'title' => 'Om oss',
            'icon'  => 'fa fa-phone fa-fw',
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
