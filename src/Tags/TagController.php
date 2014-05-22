<?php

namespace Anax\Tags;

class TagController implements \Anax\DI\IInjectionAware
{
    use \Anax\DI\TInjectable;

    /**
	* Initialize the controller.
	*
	* @return void
	*/
	public function initialize()
	{
    	$this->tags = new \Anax\Tags\Tag();
    	$this->tags->setDI($this->di);
	}

	public function nameAction($name = null)
	{
		if(empty($name))
		{
			die("Missing name.");
		}

		$questions = $this->tags->findAllByName($name);

		$this->theme->setTitle($name);
		$this->views->add('questions/list-all', [
			'title' => $name,
			'questions' => $questions,
  		]);
	}

	public function listAction()
	{
		$tags = $this->tags->findAll();

		$this->theme->setTitle('Alla taggar');
		$this->views->add('tags/list', [
			'title' => 'Alla taggar',
			'tags' => $tags,
  		]);
	}

	public function checkAction($tag)
	{
		$tags = $this->tags->findAll();

		$found = false;

		foreach($tags as $existingTag)
		{
			if($existingTag->title == $tag)
			{
				$found = true;

				$updateTag = $this->tags->find($existingTag->id);
				$updateTag->nrofquestions++;
				$updateTag->save();
			}
		}

		if(!$found)
		{
			$this->tags->add($tag);
		}
	}
}