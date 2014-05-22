<?php

namespace Anax\Comment;

class Comment extends \Anax\MVC\CDatabaseModel
{
	public function initialize()
	{
    	$this->comments = new \Anax\Comment\CommentController();
    	$this->comments->setDI($this->di);
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

	/**
	* Save current object/row.
	*
	* @param array $values key/values to save or empty to use object properties.
	*
	* @return boolean true or false if saving went okey.
	*/
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
	* Find and return all.
	*
	* @return array
	*/
	public function findAll()
	{
		$this->db->select()
	             ->from($this->getSource());
	 
	    $this->db->execute();
	    $this->db->setFetchModeClass(__CLASS__);
	    return $this->db->fetchAll();
	}	
}