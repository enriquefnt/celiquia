<?php

namespace ClassGrl;

class DataTables
{
	private $pdo;
	private $table;
	private $primaryKey;

	public function __construct(\PDO $pdo, string $table, string $primaryKey)
	{
		$this->pdo = $pdo;
		$this->table = $table;
		$this->primaryKey = $primaryKey;
	}

	private function query($sql, $parameters = [])
	{

		$query = $this->pdo->prepare($sql);

		//var_dump($parameters); 
		$query->execute($parameters);
		//var_dump($query);die;
		return $query;
	}



	public function total()
	{
		$query = $this->query('SELECT COUNT(*) FROM
	`' . $this->table . '`');
		$row = $query->fetch();
		return $row[0];
	}



	public function totalBy($field, $value)
	{
		$query = 'SELECT COUNT(*) AS `TotalBy` FROM `' . $this->table . '` WHERE `' . $field . '` = :value';

		$parameters = [
			'value' => $value
		];

		$stmt = $this->pdo->prepare($query);
		$stmt->execute($parameters);

		return $stmt->fetchColumn();
	}



	public function ultimoReg()
	{
		$sql = 'SELECT * FROM `' . $this->table . '` ORDER BY `' . $this->primaryKey . '` DESC LIMIT 1';
		$query = $this->query($sql);
		return $query->fetch();
	}

	public function findById($value)
	{
		$query = 'SELECT * FROM `' . $this->table . '` WHERE `' .
			$this->primaryKey . '` = :value';
		$parameters = [
			'value' => $value
		];
		$query = $this->query($query, $parameters);
		return $query->fetch();
	}

	public function find($field, $value)
	{
		$query = 'SELECT * FROM `' . $this->table . '` WHERE `' . $field . '` = :value';

		$values = [
			'value' => $value
		];

		$stmt = $this->pdo->prepare($query);
		$stmt->execute($values);

		return $stmt->fetchAll();
	}


	public function findLast($field, $value)
	{
		$query = 'SELECT * FROM `' . $this->table . '` WHERE `' . $field . '` = :value ORDER BY `' . $this->primaryKey . '` DESC LIMIT 1';

		$values = [
			'value' => $value
		];

		$stmt = $this->pdo->prepare($query);
		$stmt->execute($values);

		return $stmt->fetch();
	}


	private function insert($fields)
	{
		$query = 'INSERT INTO `' . $this->table . '` (';
		foreach ($fields as $key => $value) {
			$query .= '`' . $key . '`,';
		}
		$query = rtrim($query, ',');
		$query .= ') VALUES (';
		foreach ($fields as $key => $value) {
			$query .= ':' . $key . ',';
		}
		$query = rtrim($query, ',');
		$query .= ')';
		$fields = $this->processDates($fields);
		$this->query($query, $fields);
	}

	private function update($fields)
	{
		$query = ' UPDATE `' . $this->table . '` SET ';
		foreach ($fields as $key => $value) {
			$query .= '`' . $key . '` = :' . $key . ',';
		}
		$query = rtrim($query, ',');
		$query .= ' WHERE `' . $this->primaryKey . '` = :primaryKey';

		$fields['primaryKey'] = $fields[$this->primaryKey];

		$fields = $this->processDates($fields);
		$this->query($query, $fields);
	}


	public function delete($id)
	{
		$parameters = [':id' => $id];
		$this->query('DELETE FROM `' . $this->table . '` WHERE
	`' . $this->primaryKey . '` = :id', $parameters);
	}

	public function findAll()
	{
		$result = $this->query('SELECT * FROM ' .
			$this->table);
		return $result->fetchAll();
	}

	private function processDates($fields)
	{
		foreach ($fields as $key => $value) {
			if ($value instanceof \DateTime) {
				$fields[$key] = $value->format('Y-m-d');
			}
		}
		return $fields;
	}


	public function save($record)
	{
		//echo($record[$this->primaryKey]);
		$existingRecord = $this->findById($record[$this->primaryKey]);
		if ($existingRecord) {
			$this->update($record);
		} else {
			$this->insert($record);
		}
	}
}
