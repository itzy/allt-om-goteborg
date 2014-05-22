<?php

namespace Anax\MVC;
 
/**
 * Model for Users.
 *
 */
class CDatabaseModel implements \Anax\DI\IInjectionAware
{
    use \Anax\DI\TInjectable;
 

 	/**
	* Create new row.
	*
	* @param array $values key/values to save.
	*
	* @return boolean true or false if saving went okey.
	*/
	public function create($values)
	{
	    $keys   = array_keys($values);
	    $values = array_values($values);
	 
	    $this->db->insert(
	        $this->getSource(),
	        $keys
	    );
	 
	    $res = $this->db->execute($values);
	 
	    $this->id = $this->db->lastInsertId();
	 
	    return $res;
	}

	/**
	* Update row.
	*
	* @param array $values key/values to save.
	*
	* @return boolean true or false if saving went okey.
	*/
	public function update($values)
	{
	    $keys   = array_keys($values);
	    $values = array_values($values);
	 
	    // Its update, remove id and use as where-clause
	    unset($keys['id']);
	    $values[] = $this->id;
	 
	    $this->db->update(
	        $this->getSource(),
	        $keys,
	        "id = ?"
	    );
	 
	    return $this->db->execute($values);
	}

	public function updateAnyTable($values, $table)
	{
		$keys   = array_keys($values);
	    $values = array_values($values);
	 
	    // Its update, remove id and use as where-clause
	    unset($keys['id']);
	    $values[] = $this->id;
	 
	    $this->db->update(
	        $table,
	        $keys,
	        "id = ?"
	    );
	 
	    return $this->db->execute($values);	
	}

	/**
	* Delete row.
	*
	* @param integer $id to delete.
	*
	* @return boolean true or false if deleting went okey.
	*/
	public function delete($id)
	{
	    $this->db->delete(
	        $this->getSource(),
	        'id = ?'
	    );
	 
	    return $this->db->execute([$id]);
	}

	/**
	* Build a select-query.
	*
	* @param string $columns which columns to select.
	*
	* @return $this
	*/
	public function query($columns = '*')
	{
	    $this->db->select($columns)
	             ->from($this->getSource());
	 
	    return $this;
	}

	/**
	* Build the where part.
	*
	* @param string $condition for building the where part of the query.
	*
	* @return $this
	*/
	public function where($condition)
	{
	    $this->db->where($condition);
	 
	    return $this;
	}

	/**
	* Build the where part.
	*
	* @param string $condition for building the where part of the query.
	*
	* @return $this
	*/
	public function andWhere($condition)
	{
	    $this->db->andWhere($condition);
	 
	    return $this;
	}

	/**
	* Execute the query built.
	*
	* @param string $query custom query.
	*
	* @return $this
	*/
	public function execute($params = [])
	{
	    $this->db->execute($this->db->getSQL(), $params);
	    $this->db->setFetchModeClass(__CLASS__);
	 
	    return $this->db->fetchAll();
	}
}