<?php

namespace Anax\Search;

class Search extends \Anax\MVC\CDatabaseModel
{
	/**
	* Initialize the controller.
	*
	* @return void
	*/
	public function initialize()
	{
    	$this->search = new \Anax\Search\SearchController();
    	$this->search->setDI($this->di);
	}	

	public function findAllUsers($keyword)
	{
		$this->db->select()
				 ->from('user')
				 ->where('name LIKE ?');

		$this->db->execute(["%" . $keyword . "%"]);
		return $this->db->fetchAll();
	}

	public function findAllQuestions($keyword)
	{
		$this->db->select()
				 ->from('question')
				 ->where('title LIKE ?');

		$this->db->execute(["%" . $keyword . "%"]);
		return $this->db->fetchAll();
	}

	public function findAllTags($keyword)
	{
		$this->db->select()
				 ->from('question')
				 ->where('title LIKE ?');

		$this->db->execute(["%" . $keyword . "%"]);
		return $this->db->fetchAll();	
	}

}