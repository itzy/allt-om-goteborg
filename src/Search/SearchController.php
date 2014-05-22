<?php

namespace Anax\Search;

class SearchController implements \Anax\DI\IInjectionAware
{
    use \Anax\DI\TInjectable;

    /**
	* Initialize the controller.
	*
	* @return void
	*/
	public function initialize()
	{
    	$this->search = new \Anax\Search\Search();
    	$this->search->setDI($this->di);
	}

	public function forAction()
	{
		$for = $this->request->getPost('searchIn');
		$keyword = $this->request->getPost('keyword');

		if(empty($for))
		{
			die("Missing category.");
		}

		if(empty($keyword))
		{
			die("Missing keyword");
		}

		$searchResults = null;

		if($for == "Användare")
		{
			$searchResults = $this->search->findAllUsers($keyword);
		}
		else if($for == "Frågor")
		{
			$searchResults = $this->search->findAllQuestions($keyword);	
		}
		else if($for == "Taggar")
		{
			$searchResults = $this->search->findAllTags($keyword);
		}

		$this->theme->setTitle("Sökresultat för " . $keyword);
		$this->views->add('search/list', [
			'title' => $keyword,
			'searchResults' => $searchResults,
			'for'	=> $for,
			]);
	}
}