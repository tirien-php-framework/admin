<?php

abstract class Query_Builder 
{

	public $tablePrefix = "s";

	public $table = "";

	public function __construct()
	{
		return $this->table = strtolower(str_replace('Model_', '', get_class($this))) . $this->tablePrefix;
	}

	public function get()
	{
		return DB::query( "SELECT * FROM $this->table WHERE status=1");	
	}

	public function all()
	{
		return DB::query( "SELECT * FROM $this->table");	
	}

	public function create(array $data)
	{
		return DB::insert($this->table, $data);
	}

	public function find($id)
	{
		return DB::query( "SELECT * FROM $this->table WHERE status=1 and id=? LIMIT 0,1", $id, true);	
	}

	public function update($id, array $data)
	{
        return DB::update($this->table, $data, "id=".$id );
	}

	public function delete($id)
	{
		return DB::delete($this->table, "id=".$id );
	}
}