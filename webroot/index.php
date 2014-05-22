<?php

require __DIR__.'/config.php'; 
require "password.php";
date_default_timezone_set("Europe/Stockholm");

// Create services and inject into the app. 
$di  = new \Anax\DI\CDIMyFactoryDefault();
$app = new \Anax\Kernel\CAnax($di);

$di->set('form', '\Mos\HTMLForm\CForm');

$app->url->setUrlType(\Anax\Url\CUrl::URL_CLEAN);
$app->theme->configure(ANAX_APP_PATH . 'config/theme-goteborg.php');
$app->navbar->configure(ANAX_APP_PATH . 'config/navbar_goteborg.php');
$app->session();

$app->router->add('', function() use ($app) {
    $app->theme->setTitle('Home');
    
    $app->db->select()
            ->from('question')
            ->orderBy('updated DESC')
            ->execute();

    $questions = $app->db->fetchAll();

    $content = "<span class='latestBox'>";
    $content .= "<h3>Senaste frågorna</h3>";
    $content .= "- <a href='" . $app->url->create('question/id/' . $questions['0']->id) . "'>" . $questions['0']->title . "</a><br>";
    $content .= "- <a href='" . $app->url->create('question/id/' . $questions['1']->id) . "'>" . $questions['1']->title . "</a><br>";
    $content .= "- <a href='" . $app->url->create('question/id/' . $questions['2']->id) . "'>" . $questions['2']->title . "</a>";
    $content .= "</span>";  

    $app->db->select()
            ->from('tag')
            ->orderBy('nrofquestions DESC')
            ->execute();

    $tags = $app->db->fetchAll();

    $content .= "<span class='latestBox'>";
    $content .= "<h3>Populäraste taggarna</h3>";
    $content .= "- <a href='" . $app->url->create('tag/name/' . $tags['0']->title) . "'>" . $tags['0']->title . "</a> - " . $tags['0']->nrofquestions . "<br>";
    $content .= "- <a href='" . $app->url->create('tag/name/' . $tags['1']->title) . "'>" . $tags['1']->title . "</a> - " . $tags['1']->nrofquestions . "<br>";
    $content .= "- <a href='" . $app->url->create('tag/name/' . $tags['2']->title) . "'>" . $tags['2']->title . "</a> - " . $tags['2']->nrofquestions . "<br>";
    $content .= "</span>";

    $app->db->select()
            ->from('user')
            ->orderBy('posts DESC')
            ->execute();

    $users = $app->db->fetchAll();

    $content .= "<span class='latestBox'>";
    $content .= "<h3>Mest aktiva användare</h3>";
    $content .= "- <a href='" . $app->url->create('users/id/' . $users['0']->id) . "'>" . $users['0']->username . "</a> - " . $users['0']->posts . "<br>";
    $content .= "- <a href='" . $app->url->create('users/id/' . $users['1']->id) . "'>" . $users['1']->username . "</a> - " . $users['1']->posts . "<br>";
    $content .= "- <a href='" . $app->url->create('users/id/' . $users['2']->id) . "'>" . $users['2']->username . "</a> - " . $users['2']->posts . "<br>";
    $content .= "</span>";

    $app->views->add('me/index', [
        'content' => $content,
        'byline' => null,
    ]);
});

$app->router->add('about', function() use ($app) {
    $app->theme->setTitle('Om oss');
    $content = $app->textFilter->doFilter($app->fileContent->get('about.md'), 'shortcode, markdown');

    $app->views->add('me/index', [
        'content' => $content,
        'byline' => null,
        ]);
});

$app->router->add('newQuestion', function() use ($app){
    
    $app->theme->setTitle("Ny Fråga");

    $url = $app->url->create('question/add');

    $content = <<<EOD
    <form class="profileForm" method="post">
    <p><label>Title: </label> <input type="text" name="title"></p>
    <p><label>Tags: <i>"php,phptesting"</i></label><input type="text" name="tags"></p>
    <p><label>Content: </label><textarea name="content"></textarea></p>
    <p><input type="submit" name="doSubmit" value="Lägg till fråga" onClick="this.form.action = '$url'"></p>
    </form>
EOD;

    $app->views->add('me/index', [
        'content' => $content,
        'byline'  => null
    ]);

});

$app->router->add('report', function() use ($app) {
    $app->theme->setTitle("Redovisning");

    $content = $app->textFilter->doFilter($app->fileContent->get('project-report.md'), 'shortcode, markdown');
    $app->views->add('me/index', [
        'content' => $content,
    ]);
});

$app->router->add('source', function() use ($app) {

    $app->theme->setTitle("Källkod");
 
    $source = new \Mos\Source\CSource([
        'secure_dir' => '..', 
        'base_dir' => '..', 
        'add_ignore' => ['.htaccess'],
    ]);
 
    $app->views->add('me/source', [
        'content' => $source->View(),
    ]);
});

/*$app->router->add('setup', function() use($app) {
    $app->db->dropTableIfExists('user')->execute();
 
    $app->db->createTable(
        'user',
        [
            'id' => ['integer', 'primary key', 'not null', 'auto_increment'],
            'acronym' => ['varchar(20)', 'unique', 'not null'],
            'username' => ['varchar(80)'],
            'email' => ['varchar(80)'],
            'name' => ['varchar(80)'],
            'password' => ['varchar(255)'],
            'birthdate' => ['datetime'],
            'posts' => ['integer'],
            'created' => ['datetime'],
            'updated' => ['datetime'],
            'deleted' => ['datetime'],
            'active' => ['datetime'],
        ]
    )->execute();

      $app->db->insert(
        'user',
        ['acronym', 'username', 'email', 'name', 'password', 'birthdate', 'posts', 'created', 'active']
    );
 
    $now = date(DATE_RFC2822);
 
    $app->db->execute([
        'femo13',
        'feeloor',
        'felix@khoi.se',
        'Felix Khoi',
        md5('felix123'),
        'Mon, 13 Feb 1995 23:56:02 +0000',
        3,
        $now,
        $now
    ]);
 
    $app->db->execute([
        'doe',
        'johndoe',
        'doe@dbwebb.se',
        'John/Jane Doe',
        md5('doe'),
        $now,
        2,
        $now,
        $now
    ]);

    $app->db->execute([
        'admin',
        'admin',
        'admin@felixkhoi.se',
        'Administratör',
        md5('admin123'),
        $now,
        0,
        $now,
        $now
    ]);
});

$app->router->add('questionss', function() use ($app) {
    $app->theme->setTitle("Setup");
    
    $app->db->dropTableIfExists('question')->execute();

    $app->db->createTable(
        'question',
        [ 
            'id' => ['integer', 'primary key', 'not null', 'auto_increment'],
            'title' => ['varchar(100)'],
            'created' => ['datetime'],
            'updated' => ['datetime'],
            'nrofposts' => ['integer'],
            'tags' => ['varchar(255)'],
        ]
    )->execute();

    $app->db->insert(
        'question',
        ['title', 'created', 'updated', 'nrofposts', 'tags']
    );

    $app->db->execute([
        'Test fråga',
        date(DATE_RFC2822),
        date(DATE_RFC2822),
        2,
        'testing,php,phptesting',
    ]);

    $app->db->execute([
        'Test fråga 2',
        date(DATE_RFC2822),
        date(DATE_RFC2822),
        2,
        'test,php,php-testing',
    ]);

    $app->db->execute([
        'Test fråga 3',
        date(DATE_RFC2822),
        date(DATE_RFC2822),
        1,
        'test,php,php-testing',
    ]);

    $app->db->dropTableIfExists('answers')->execute();

    $app->db->createTable(
        'answers',
        [
            'id' => ['integer', 'primary key', 'not null', 'auto_increment'],
            'question_id' => ['integer'],
            'username' => ['varchar(80)'],
            'email'   => ['varchar(80)'],
            'content' => ['text'],
            'created' => ['datetime'],
            'updated' => ['datetime'],
            'thumbs'  => ['integer'],
        ]
    )->execute();

    $app->db->insert(
        'answers',
        ['question_id', 'username', 'email', 'content', 'created', 'thumbs']
    );

    $app->db->execute([
        1,
        'feeloor',
        'felix@khoi.se',
        'Testar om det fungerar att svara och allt sådant.',
        date(DATE_RFC2822),
        0,
    ]);

    $app->db->execute([
        2,
        'feeloor',
        'felix@khoi.se',
        'sTestar om det fungerar att svara och allt sådant.',
        date(DATE_RFC2822),
        0,
    ]);

    $app->db->execute([
        3,
        'feeloor',
        'felix@khoi.se',
        'Testarrrrrrrrrrrrr om det fungerar att svara och allt sådant.',
        date(DATE_RFC2822),
        0,
    ]);

    $app->db->execute([
        1,
        'johndoe',
        'doe@dbwebb.se',
        'ssTestar om det fungerar att svara och allt sådant.',
        date(DATE_RFC2822),
        0,
    ]);

    $app->db->execute([
        2,
        'johndoe',
        'doe@dbwebb.se',
        'sssTestar om det fungerar att svara och allt sådant.',
        date(DATE_RFC2822),
        0,
    ]);
});

$app->router->add('tagss', function() use ($app) {
    
    $app->theme->setTitle("Tags setup");

    $app->db->dropTableIfExists('tag')->execute();

    $app->db->createTable(
        'tag',
        [
            'id' => ['integer', 'primary key', 'not null', 'auto_increment'],
            'title' => ['varchar(80)'],
            'nrofquestions' => ['integer'],
        ]  
    )->execute();

    $app->db->insert(
        'tag',
        ['title', 'nrofquestions']
    );

    $app->db->execute([
        'testing',
        1,
    ]);

    $app->db->execute([
        'php',
        3,
    ]);

    $app->db->execute([
        'phptesting',
        1,
    ]);

    $app->db->execute([
        'php-testing',
        2,
    ]);

    $app->db->execute([
        'test',
        2,
    ]);
});*/ 

$app->router->handle();
$app->theme->render();