<?php

namespace Feeloor\Table;

class CTable
{

	private $table; //The complete table.
	private $tableClass; //Lets the user choose what table-class to use.
	private $data = array(); //Array to store all data.
	private $errors = array(); //Array to store errors.

	/**
	* The "main" function to create the table for the user.
	*
	*/
	public function create($table = [], $verbose = false)
	{
		if(!$this->tableIsValid($table))
		{
			if($verbose)
			{
				die(var_dump($this->errors));
			} else {
				$errorMessage = "Could not create table, missing fields: <br>";

				foreach($this->errors as $error)
				{
					$errorMessage .= "- " . $error . "<br>";
				}

				die($errorMessage);
			}
		}

		$this->tableClass = $table['tableClass'];
		$this->data = $table['data'];
	}


	/*
	* Creates the html code and returns it.
	*
	*/
	public function showTable()
	{
		$this->table .= "<table class ='" . $this->tableClass . "'>";

		foreach($this->data as $tr)
		{
			$this->table .= "<tr>";

			foreach($tr as $key => $value)
			{
				$this->table .= "<" . $value['type'] . " class ='" . $value['class'] .  "'>";
				$this->table .= $value['content'];
				$this->table .= "</" . $value['type'] . ">";
			}

			$this->table .= "</tr>";
		}
		$this->table .= "</table>";

		return $this->table;
	}


	/*
	* Validates the incoming table values.
	*
	*/
	public function tableIsValid($table = [])
	{
		if(!isset($table['tableClass']))
		{
			$this->errors[] = "Missing table class.";
		}

		if(!isset($table['data']))
		{
			$this->errors[] = "Missing table data.";
		}

		if(empty($this->errors))
		{
			return true;
		} else {
			return false;
		}
	}
}