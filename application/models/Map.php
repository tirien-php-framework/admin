<?php

require_once(dirname(__FILE__).'/'.'Query_Builder.php'); 

class Model_Map extends Query_Builder
{
	public function getLocations($map_id)
	{
		$this->Location = new Model_Location();
		return $this->Location->where('map_id', $map_id);
	}
}
