<?php

namespace Anax\Questions;

class QuestionController implements \Anax\DI\IInjectionAware
{
    use \Anax\DI\TInjectable;

    /**
	* Initialize the controller.
	*
	* @return void
	*/
	public function initialize()
	{
    	$this->questions = new \Anax\Questions\Question();
    	$this->questions->setDI($this->di);
	}

	public function listAllAction()
	{
		$questions = $this->questions->findAll();

		$this->theme->setTitle("Alla frågor");
		$this->views->add('questions/list-all', [
			'questions' => $questions,
			'title'		=> 'Alla frågor',
		]);
	}

	public function idAction($id = null)
	{
		if(!isset($id)) 
		{
			die("Missing id.");
		}

		$question = $this->questions->find($id);
		$answers = $this->questions->findAnswers($id);

		$this->theme->setTitle($question->title);
		$this->views->add('questions/view', [
			'title' => $question->title,
			'question' => $question, 
			'answers' => $answers,
		]);
	}

	public function addAction()
	{
		if(!$this->request->getPost('doSubmit'))
		{
			die("Missing info.");
		}

		$tags = explode(',', $this->request->getPost('tags'));

		foreach($tags as $tag)
		{
			$this->dispatcher->forward([
				'controller' => 'tag',
				'action'	 => 'check',
				'params' 	 => [$tag],
			]);
		}

		$this->questions->save([
			'title' 	=> $this->request->getPost('title'),
			'created' 	=> date(DATE_RFC2822),
			'updated'	=> date(DATE_RFC2822),
			'nrofposts' => 1,
			'tags' 		=> $this->request->getPost('tags'),
		]);

		$user = $this->session->get("logged_in");

		$this->questions->saveAnswer([
			'question_id' => $this->questions->id,
			'username' 	  => $user['username'],
			'email'	      => $user['email'],
			'content'     => $this->request->getPost('content'),
			'created'     => date(DATE_RFC2822),
			'thumbs'      => 0,
		]);

		$this->response->redirect($this->url->create('question/id/' . $this->questions->id));
	}

	public function listAllFromUserAction($username = null)
	{
		if(empty($username))
		{
			die("Missing username.");
		}

		$answers = $this->questions->findAllAnswersByUser($username);

		$this->views->add('me/index', [
			'content' => "<h2>Delaktig i dessa frågor: </h2>",
			'byline' => null,
			]);

		foreach($answers as $answer)
		{
			$question = $this->questions->find($answer->question_id);
			$content = "<a href='" . $this->url->create('question/id/') . "/" . $question->id . "'><font size='4px'><b>" . $question->title . "</b></font></a><br>";

			$this->views->add('me/index', [
				'content' => $content,
				'byline' => null,
				]);
		}
	}

	public function addAnswerAction()
	{
		if(!$this->request->getPost('doSave'))
		{
			die("Missing info.");
		}

		$user = $this->session->get('logged_in');
		$question = $this->questions->find($this->request->getPost('question_id'));

		$question->updated = date(DATE_RFC2822);
		$question->nrofposts++;
		$question->save();

		$content = $this->textFilter->markdown($this->request->getPost('content'), 'shortcode, markdown');
		$this->questions->saveAnswer([
			'question_id' => $this->request->getPost('question_id'),
			'username' 	  => $user['username'],
			'email'	      => $user['email'],
			'content'     => $content,
			'created'     => date(DATE_RFC2822),
			'thumbs'      => 0,
		]);

		$this->dispatcher->forward([
			'controller' => 'users',
			'action' => 'posts',
			'params' => [$user['id'], ($user['posts'] + 1)],
			]);

		$this->response->redirect($this->url->create('question/id/' . $this->request->getPost('question_id')));
	}

	public function thumbsUpAction($answer_id = null, $question_id = null)
	{
		if(!isset($answer_id))
		{
			die("Missing answer id.");
		}

		if(!isset($question_id))
		{
			die("Missing question id.");
		}

		$answer = $this->questions->findAnswer($answer_id);
	
		$answer->thumbs++;
		$answer->updated = date(DATE_RFC2822);

		$answer->updateAnswer();

		$this->response->redirect($this->url->create('question/id/' . $question_id));
	}

	public function thumbsDownAction($answer_id = null, $question_id = null)
	{
		if(!isset($answer_id))
		{
			die("Missing answer id.");
		}

		if(!isset($question_id))
		{
			die("Missing question id.");
		}

		$answer = $this->questions->findAnswer($answer_id);
	
		$answer->thumbs--;
		$answer->updated = date(DATE_RFC2822);

		$answer->updateAnswer();

		$this->response->redirect($this->url->create('question/id/' . $question_id));
	}
}