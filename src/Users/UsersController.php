<?php

namespace Anax\Users;
 
/**
 * A controller for users and admin related events.
 *
 */
class UsersController implements \Anax\DI\IInjectionAware
{
    use \Anax\DI\TInjectable;

    /**
	* Initialize the controller.
	*
	* @return void
	*/
	public function initialize()
	{
    	$this->users = new \Anax\Users\User();
    	$this->users->setDI($this->di);
	}

	/**
	* List user with id.
	*
	* @param int $id of user to display
	*
	* @return void
	*/
	public function idAction($id = null)
	{	
		if(!isset($id))
		{
			$user = $this->session->get('logged_in');
			$id = $user['id'];

			if(!isset($id))
			{
				die("Missing id.");
			}
		}

	    $user = $this->users->find($id);
	 
	 	$this->theme->setTitle($user->name . "'s profil");
	    $this->views->add('users/view', [
	        'user' => $user
	    ]);

	    $this->dispatcher->forward([
		'controller' => 'question',
		'action' => 'listAllFromUser',
		'params' => [$user->username],
		]);
	}

	/**
	* List user with id.
	*
	* @param int $id of user to display
	*
	* @return void
	*/
	public function usernameAction($username = null)
	{	
		if(!isset($username))
		{
			die("Missing username.");
		}

	    $user = $this->users->findByUsername($username);
	 
	 	$this->theme->setTitle($user->name . "'s profil");
	    $this->views->add('users/view', [
	        'user' => $user
	    ]);

	    $this->dispatcher->forward([
		'controller' => 'question',
		'action' => 'listAllFromUser',
		'params' => [$user->username],
		]);
	}

	/**
	* List all users.
	*
	* @return void
	*/
	public function listAction()
	{
		$this->initialize(); 

		$all = $this->users->findAll();
	 
	    $this->theme->setTitle("Alla användare");
	    $this->views->add('users/list-all', [
	        'users' => $all,
	        'title' => "Alla användare",
	    ]);
	}

	public function listInactiveAction()
	{
		$this->initialize(); 

		$all = $this->users->findAllInactive();
	 
	    $this->theme->setTitle("Alla inaktiva användare");
	    $this->views->add('users/list-all', [
	        'users' => $all,
	        'title' => "Alla inaktiva användare",
	    ]);
	}

	/**
	* Add new user.
	*
	* @param string $acronym of user to add.
	*
	* @return void
	*/
	public function addAction($acronym = null)
	{
	    if (!isset($acronym)) {
	        die("Missing acronym");
	    }
	 
	    $now = date(DATE_RFC2822);
	 
	    $this->users->save([
	        'acronym' => $acronym,
	        'email' => $acronym . '@mail.se',
	        'name' => 'Mr/Mrs ' . $acronym,
	        'password' => password_hash($acronym, PASSWORD_DEFAULT),
	        'birthdate' => $now,
	        'posts' => 0,
	        'created' => $now,
	        'active' => $now,
	    ]);
	 
	    $url = $this->url->create('users/id/' . $this->users->id);
	    $this->response->redirect($url);
	}

	/**
	* Delete user.
	*
	* @param integer $id of user to delete.
	*
	* @return void
	*/
	public function deleteAction($id = null)
	{
	    if (!isset($id)) {
	        die("Missing id");
	    }
	 
	    $res = $this->users->delete($id);
	 
	    $url = $this->url->create('users/list');
	    $this->response->redirect($url);
	}

	/**
	* Update user.
	*
	* @param integer $id of user to update.
	*
	* @return void
	*/
	public function updateAction($id = null)
	{
	    if (!isset($id)) {
	 		$user = $this->session->get('logged_in');
			$id = $user['id'];

	 		if(!isset($id)) {
	 			die("Missing id.");
	 		}
	    }
	 	
	 	$user = $this->users->find($id);

	 	$this->theme->setTitle($user->name . "'s profil");
	    $this->views->add('users/update', [
	    	'user' => $user
	    ]);
	}

	/**
	* Delete (soft) user.
	*
	* @param integer $id of user to delete.
	*
	* @return void
	*/
	public function softDeleteAction($id = null)
	{
	    if (!isset($id)) {
	        die("Missing id");
	    }
	 
	    $now = date(DATE_RFC2822);
	 
	    $user = $this->users->find($id);
	 
	    $user->deleted = $now;
	    $user->save();
	 
	    $url = $this->url->create('users/id/' . $id);
	    $this->response->redirect($url);
	}

	public function undoSoftDeleteAction($id = null)
	{
		if(!isset($id)) {
			die("Missing id");
		}

		$now = date(DATE_RFC2822);

		$user = $this->users->find($id);

		$user->deleted = null;
		$user->save();

		$this->response->redirect($this->url->create('users/id/' . $id));
	}

	/**
	* List all active and not deleted users.
	*
	* @return void
	*/
	public function activeAction()
	{
	    $all = $this->users->query()
	        ->where('active IS NOT NULL')
	        ->andWhere('deleted is NULL')
	        ->execute();
	 
	    $this->theme->setTitle("Users that are active");
	    $this->views->add('users/list-all', [
	        'users' => $all,
	        'title' => "Users that are active",
	    ]);
	}

	public function saveAction()
	{
		if(!$this->request->getPost('doSubmit'))
		{
			$this->response->redirect($this->request->getPost('redirect'));	
		}

		$user = $this->users->find($this->request->getPost('id'));

		$user->acronym = $this->request->getPost('acronym');
		$user->username = $this->request->getPost('username');
		$user->name = $this->request->getPost('name');
		$user->birthdate = $this->request->getPost('birthdate');
		$user->email = $this->request->getPost('email');
		$user->updated = date(DATE_RFC2822);

		$user->save();

		$this->response->redirect($this->url->create('users/id/' . $this->request->getPost('id')));
	}

	public function loginAction()
	{
		if(!$this->request->getPost('login'))
		{
			$this->response->redirect($this->request->getPost('redirect'));
		}

		$user = $this->users->findByUsername($this->request->getPost('username'));

		if(empty($user))
		{
			$this->theme->setTitle('Något gick fel...');
			$this->views->add('users/login-error', [
				'error' => "Något gick fel vid inloggning, försök igen."
			]);

			return;
		}

		if($user->password == (md5($this->request->getPost('password'))))
		{
			$user->active = date(DATE_RFC2822);

			$userInfo = [
			'id' => $user->id,
			'acronym' => $user->acronym,
			'username' => $user->username,
			'email' => $user->email,
			'name' => $user->name,
			'birthdate' => $user->birthdate,
			'posts' => $user->posts,
			];

			$this->session->set('logged_in', $userInfo);
			$this->response->redirect($this->request->getPost('redirect'));
		} else {
			$this->theme->setTitle('Något gick fel...');
			$this->views->add('users/login-error', [
				'error' => "Något gick fel vid inloggning, försök igen."
			]);
		}
	}

	public function logoutAction()
	{
		$user = $this->session->get('logged_in');
		$userID = $user['id'];

		if(empty($userID))
		{
			die("Missing id");
		}

		$this->session->set('logged_in', null);
		$this->theme->setTitle('Logga ut');
		$this->views->add('users/login-error', [
			'error' => "Du är nu utloggad!"
		]);
	}

	public function gravatarAction($username)
	{
		if(empty($username))
		{
			die("Missing username.");
		}

		$user = $this->users->findByUsername($username);

		$gravatar = 'http://www.gravatar.com/avatar/' . md5(strtolower(trim($user->email))) . '.jpg?s=60';

		return $user->email;
	}

	public function postsAction($id, $posts)
	{
		if(!isset($id)) 
		{
			die("Missing id.");
		}

		if(!isset($posts))
		{
			die("Missing posts.");
		}

		$user = $this->users->find($id);

		$user->posts = $posts;
		$user->save();
	}
}