<?php

namespace Anax\Tags;

class Tag extends \Anax\MVC\CDatabaseModel
{
	public function initialize()
	{
		$this->tags = \Anax\Tags\TagController();
		$this->tags->setDI($this->di);
	}

	public function add($tag = null)
	{
		if(empty($tag))
		{
			die("Missing tag.");
		}

		$values = ['title' => $tag, 'nrofquestions' => 1];

		$this->create($values);
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

	public function find($id)
	{
	    $this->db->select()
	             ->from($this->getSource())
	             ->where("id = ?");
	 
	    $this->db->execute([$id]);
	    return $this->db->fetchInto($this);
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

	public function findAllByName($name = null)
	{
		if(empty($name))
		{
			die("Missing name.");
		}

		$this->db->select()
				 ->from('question');

		$this->db->execute();
		$questions = $this->db->fetchAll();
		$all = null;

		foreach($questions as $question)
		{
			$tags = explode(',', $question->tags);

			foreach($tags as $tag)
			{
				if($name == $tag)
				{
					$all[] = $question;
				}
			}
		}

		return $all;
	}

	public function findAll()
	{
		$this->db->select()
				 ->from($this->getSource());

		$this->db->execute();
	    $this->db->setFetchModeClass(__CLASS__);
		return $this->db->fetchAll();
	}

	public function getSource()
	{
	    return strtolower(implode('', array_slice(explode('\\', get_class($this)), -1)));
	}
}