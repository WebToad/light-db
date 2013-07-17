<?php

namespace Models;

use Nette\Database\Connection;
use Nette\Database\Table\ActiveRow;
use Nette\Database\Table\Selection;
use Nette\Object;

/**
 * Abstract model for all models
 *
 * @author Milan Felix Sulc <sulc@webtoad.cz>
 * @version 0.1
 */
abstract class Model extends Object implements IModel
{
	/** @var Connection */
	private $connection;

	/** @var string */
	protected $table;

	/** @var string */
	protected $primaryKey = 'id';

	/**
	 * @param Connection $connection
	 */
	public function __construct(Connection $connection)
	{
		$this->connection = $connection;
	}

	/**
	 * @return Connection
	 */
	protected function getConnection()
	{
		return $this->connection;
	}

	/** API ********************************************************************************************************* */

	/**
	 * Gets table name
	 *
	 * @return string
	 */
	abstract protected function getTable();

	/**
	 * @return Selection
	 */
	protected function prepare()
	{
		return $this->connection->table($this->table);
	}

	/**
	 * @param array $data
	 * @return ActiveRow
	 */
	public function insert(array $data)
	{
		return $this->prepare()->insert($data);
	}

	/**
	 * @param array $data
	 * @param int $id
	 * @return int
	 */
	public function update(array $data, $id)
	{
		return $this->prepare()->where(array($this->primaryKey => $id))->update($data);
	}

	/**
	 * @param array $data
	 * @param array $conditions
	 * @return int
	 */
	public function updateBy(array $data, array $conditions)
	{
		return $this->prepare()->where($conditions)->update($data);
	}

	/**
	 * @param $id
	 * @param string $column
	 * @return ActiveRow
	 */
	public function load($id)
	{
		return $this->prepare()->find($id)->fetch();
	}

	/**
	 * @param array $conditions
	 * @return ActiveRow
	 */
	public function loadBy(array $conditions)
	{
		return $this->prepare()->where($conditions)->fetch();
	}

	/**
	 * @param array $conditions
	 * @return Selection
	 */
	public function loadAll(array $conditions = array())
	{
		return $this->prepare()->where($conditions);
	}

	/**
	 * @param $id
	 * @return int
	 */
	public function delete($id)
	{
		return $this->deleteBy(array($this->primaryKey => $id));
	}

	/**
	 * @param array $conditions
	 * @return int
	 */
	public function deleteBy(array $conditions)
	{
		return $this->prepare()->where($conditions)->delete();
	}

	/**
	 * @param string $sql
	 * @return mixed
	 */
	protected function query($sql)
	{
		return $this->connection->query($sql);
	}

	/**
	 * @param string $name
	 * @return Selection
	 */
	protected function selection($name = NULL)
	{
		return $this->connection->table(($name == NULL ? $this->getTable() : $name));
	}

	/**
	 * Transaction: begin
	 *
	 * @return void
	 */
	public function begin()
	{
		if (!$this->connection->inTransaction()) {
			$this->connection->beginTransaction();
		}
	}

	/**
	 * Transaction: commit
	 *
	 * @return void
	 */
	public function commit()
	{
		if ($this->connection->inTransaction()) {
			$this->connection->commit();
		}
	}

	/**
	 * Transaction: rollback
	 *
	 * @return void
	 */
	public function rollback()
	{
		if ($this->connection->inTransaction()) {
			$this->connection->rollBack();
		}
	}
}
