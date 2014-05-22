<?php

namespace Anax\DI;

/**
* My own set of extended services.
*
*/
class CDIMyFactoryDefault extends CDIFactoryDefault
{
   /**
     * Construct.
     *
     */
    public function __construct()
    {
        parent::__construct();

        $this->setShared('db', function() {
            $db = new \Mos\Database\CDatabaseBasic();
            $db->setOptions(require ANAX_APP_PATH . 'config/database_sqlite.php');
            $db->connect();
            return $db;
        });

        $this->set('UsersController', function() {
            $controller = new \Anax\Users\UsersController();
            $controller->setDI($this);
            return $controller;
        });

        $this->set('QuestionController', function() {
            $questions = new \Anax\Questions\QuestionController();
            $questions->setDI($this);
            return $questions;
        });

        $this->set('SearchController', function() {
            $search = new \Anax\Search\SearchController();
            $search->setDI($this);
            return $search;
        });        

        $this->set('TagController', function() {
            $tags = new \Anax\Tags\TagController();
            $tags->setDI($this);
            return $tags;
        });        
    }
}