<?php

namespace Anax\Comment;

class CommentController implements \Anax\DI\IInjectionAware
{
    use \Anax\DI\TInjectable;
	
	public function initialize()
	{
    	$this->comments = new \Anax\Comment\Comment();
    	$this->comments->setDI($this->di);
	}

	public function addAction()
	{
		if(!$this->request->getPost('addComment'))
		{
			$this->response->redirect($this->request->getPost('redirect'));
		}

		$this->comments->save([
			'content'   => $this->request->getPost('content'),
            'name'      => $this->request->getPost('name'),
            'web'       => $this->request->getPost('web'),
            'mail'      => $this->request->getPost('mail'),
            'timestamp' => time(),
            'ip'        => $this->request->getServer('REMOTE_ADDR'),
            'thumbs'    => 0,
		]);

		$this->response->redirect($this->request->getPost('redirect'));
	}

	public function listAction()
	{
		$allComments = $this->comments->findAll();

		$this->views->add('comment/list-all', [
				'title'	   => 'Kommentarer',
				'comments' => $allComments
		]);
	}

	public function removeAction($id = null)
	{
		if (!isset($id)) {
	        die("Missing id");
	    }

	    $this->comments->delete($id);

	    $this->response->redirect($this->request->getPost('redirect'));
	}

	public function thumbsUpAction($id = null)
	{
		if (!isset($id)) {
	        die("Missing id");
	    }

	    $comment = $this->comments->find($id);

	    $thisComment = $comment->getProperties();
	    $thisComment['thumbs']++;

	    $comment->save($thisComment);

	    $this->response->redirect($this->request->getPost('redirect'));	
	}

	public function thumbsDownAction($id = null)
	{
		if (!isset($id)) {
	        die("Missing id");
	    }

	    $comment = $this->comments->find($id);

	    $thisComment = $comment->getProperties();
	    $thisComment['thumbs']--;

	    $comment->save($thisComment);

	    $this->response->redirect($this->request->getPost('redirect'));	
	}	

	public function editAction($id = null)
	{
		if(!isset($id)) {
			die("Missing id");
		}

		$comment = $this->comments->find($id);

		$this->views->add('comment/update', [
			'comment' => $comment
		]);
	}

	public function saveAction()
	{
		if(!$this->request->getPost('doSubmit'))
		{
			$this->response->redirect($this->request->getPost('redirect'));	
		}

		$comment = $this->comments->find($this->request->getPost('id'));

		$comment->name = $this->request->getPost('name');
		$comment->mail = $this->request->getPost('mail');
		$comment->web = $this->request->getPost('web');
		$comment->content = $this->request->getPost('content');
		$comment->updated = date(DATE_RFC2822);

		$comment->save();

		$this->response->redirect($this->url->create('comment/list'));
	}
}