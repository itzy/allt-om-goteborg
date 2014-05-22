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
        'hem' => [
            'text'  => 'Tillbaka', 
            'url'   => '../',  
            'title' => 'Tillbaka till webroot',
            'icon'  => 'fa fa-long-arrow-left fa-fw',
        ],

        // This is a menu item
        'add'  => [
            'text'  => 'Add',   
            'url'   => 'add',  
            'title' => 'Lägg till användare',
            'icon'  => 'fa fa-plus fa-fw',
        ],
 
        // This is a menu item
        'update'  => [
            'text'  => 'Update',   
            'url'   => 'update',   
            'title' => 'Uppdatera användare',
            'icon'  => 'fa fa-pencil fa-fw',
        ],
 
        // This is a menu item
        'delete' => [
            'text'  =>'Delete', 
            'url'   =>'delete',  
            'title' => 'Ta bort användare',
            'icon'  => 'fa fa-trash-o fa-fw',
        ],

        // This is a menu item
        'list' => [
            'text'  =>'List', 
            'url'   => 'users/list',  
            'title' => 'Lista alla användare',
            'icon'  => 'fa fa-list-alt fa-fw',

            'submenu' => [

                'items' => [

                   // This is a menu item of the submenu
                    'list'  => [
                        'text'  => 'Inactive users',   
                        'url'   => 'users/listInactive',  
                        'title' => 'Lista över inaktiverade användare'
                    ],

                    'all-list' => [
                        'text' => 'Show all',
                        'url'  => 'users/list',
                        'title' => 'Lista alla användare'
                    ],
                ],
            ],
        ],

        // This is a menu item
        'id' => [
            'text'  =>'Show user', 
            'url'   =>'id',  
            'title' => 'Visa användare',
            'icon'  => 'fa fa-search fa-fw',
        ],

        // This is a menu item
        'soft-delete' => [
            'text'  => 'Soft-delete', 
            'url'   => 'soft-delete',  
            'title' => 'Soft delete',
            'icon'  => 'fa fa-trash-o fa-fw',
            
            'submenu' => [

                'items' => [

                    // This is a menu item of the submenu
                    'doSoftDelete'  => [
                        'text'  => 'Soft-delete',   
                        'url'   => 'soft-delete',  
                        'title' => 'Soft delete'
                    ],

                    // This is a menu item of the submenu
                    'undoSoftDelete'  => [
                        'text'  => 'Undo soft-delete',   
                        'url'   => 'undo-soft-delete',  
                        'title' => 'Undo soft delete'
                    ],
                ],
            ],
        ],        

        // This is a menu item
        'setup' => [
            'text'  =>'Setup', 
            'url'   =>'setup',  
            'title' => 'Sätter upp databasen',
            'icon'  => 'fa fa-bolt fa-fw'
        ],

        // This is a menu item
        'setup-comment' => [
            'text'  =>'Setup Comments', 
            'url'   => 'setup-comment',  
            'title' => 'Sätter upp databasen',
            'icon'  => 'fa fa-bolt fa-fw'
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
