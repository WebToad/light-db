<?php

namespace Models;

use Nette\Database\Table\ActiveRow;
use Nette\Database\Table\Selection;

/**
 * Interface for all models
 *
 * @author Milan Felix Sulc <sulc@webtoad.cz>
 * @version 0.1
 */
interface IModel
{

	/**
	 * @return string
	 */
	public function getTable();

	/**
	 * @param array $data
	 * @return ActiveRow
	 */
	public function insert(array $data);

	/**
	 * @param array $data
	 * @param $id
	 * @return int
	 */
	public function update(array $data, $id);

	/**
	 * @param array $data
	 * @param array $conditions
	 * @return int
	 */
	public function updateBy(array $data, array $conditions);

	/**
	 * @param $id
	 * @return ActiveRow
	 */
	public function load($id);

	/**
	 * @param array $conditions
	 * @return ActiveRow
	 */
	public function loadBy(array $conditions);

	/**
	 * @param array $conditions
	 * @return mixed
	 */
	public function loadAll(array $conditions = array());

	/**
	 * @param $id
	 * @return int
	 */
	public function delete($id);

	/**
	 * @param array $conditions
	 * @return int
	 */
	public function deleteBy(array $conditions);

	/**
	 * @param $sql
	 * @return mixed
	 */
	public function query($sql);

	/**
	 * @param string $table
	 * @return Selection
	 */
	public function selection($table);

	/** **************************** Transaction - START **************************** */

	/**
	 * Transaction: begin
	 *
	 * @return void
	 */
	public function begin();

	/**
	 * Transaction: commit
	 *
	 * @return void
	 */
	public function commit();

	/**
	 * Transaction: rollback
	 *
	 * @return void
	 */
	public function rollback();

	/** **************************** Transaction - END **************************** */

}

