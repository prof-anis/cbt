<?php

namespace App\Utilities\Contracts;


interface ConnectionContract{

	public function getMany(String $sql);

	public function pushInsert(String $sql) : bool;

	public function deleteData(String $sql): bool;

	public static function getInstance();

	public function closeconn();
}