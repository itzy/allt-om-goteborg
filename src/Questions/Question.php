<?php

namespace Anax\Questions;

class Question extends \Anax\MVC\CDatabaseModel
{
	/**
	* Initialize the controller.
	*
	* @return void
	*/
	public function initialize()
	{
    	$this->questions = new \Anax\Questions\QuestionsController();
    	$this->questions->setDI($this->di);
	}	

	/**
	* Set object properties.
	*
	* @param array $properties with properties to set.
	*
	* @return void
	*/
	public function setProperties($properties)
	{
	    // Update object with incoming values, if any
	    if (!empty($properties)) {
	        foreach ($properties as $key => $val) {
	            $this->$key = $val;
	        }
	    }
	}

	/**
	* Get object properties.
	*
	* @return array with object properties.
	*/
	public function getProperties()
	{
	    $properties = get_object_vars($this);
	    unset($properties['di']);
	    unset($properties['db']);
	 
	    return $properties;
	}

	/**
	* Get the table name.
	*
	* @return string with the table name.
	*/
	public function getSource()
	{
	    return strtolower(implode('', array_slice(explode('\\', get_class($this)), -1)));
	}

	public function findAll()
	{
		$this->db->select()
	             ->from($this->getSource());
	 
	    $this->db->execute();
	    $this->db->setFetchModeClass(__CLASS__);
	    return $this->db->fetchAll();
	}

	/**
	* Find and return specific.
	*
	* @return this
	*/
	public function find($id)
	{
	    $this->db->select()
	             ->from($this->getSource())
	             ->where("id = ?");
	 
	    $this->db->execute([$id]);
	    return $this->db->fetchInto($this);
	}

	public function findAnswer($id)
	{
		$this->db->select()
				 ->from('answers')
				 ->where('id = ?');

		$this->db->execute([$id]);
		return $this->db->fetchInto($this);
	}

	public function findAllAnswersByUser($username)
	{
		$this->db->select()
				 ->from('answers')
				 ->where('username = ?');

		$this->db->execute([$username]);
		return $this->db->fetchAll();
	}

	public function findAnswers($id)
	{
		$this->db->select()
				 ->from('answers')
				 ->where("question_id = ?");

		$this->db->execute([$id]);
		return $this->db->fetchAll();
	}

	public function save($values = [])
	{
	    $this->setProperties($values);
	    $values = $this->getProperties();
	 
	    if (isset($values['id'])) {
	        return $this->update($values);
	    } else {
	        return $this->create($values);
	    }
	}

	public function saveAnswer($values = [])
	{		
	    $this->db->insert(
        	'answers',
        	['question_id', 'username', 'email', 'content', 'created', 'thumbs']
    	);

    	$this->db->execute([
    		$values['question_id'],
    		$values['username'],
    		$values['email'],
    		$values['content'],
    		$values['created'],
    		$values['thumbs'],
    	]);
    }

    public function updateAnswer($values = [])
    {
    	$this->setProperties($values);
	    $values = $this->getProperties();

	    if (isset($values['id'])) {
	        $this->updateAnyTable($values, 'answers');
	    } else {
	        return $this->create($values);
	    }
    }
}
