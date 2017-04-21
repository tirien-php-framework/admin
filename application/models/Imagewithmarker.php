<?php 
Class Model_Imagewithmarker{

	public function getAll(){
		return $rs =  DB::query("SELECT * FROM imagewithmarkers WHERE status=1 ORDER BY id DESC");	
	}

	public function getByClass($className){
		return $rs =  DB::query("SELECT * FROM imagewithmarkers WHERE className = ? AND status=1 ORDER BY order_number",$className );	
	}

	public function updateAll( $imagewithmarkers ){
		foreach ($imagewithmarkers as $key => $content) {
			$return = DB::update("imagewithmarkers", $content, "id=".$key);	
		}

		return true;
	}
	public function updataLocataion( $content, $locationId ){
		DB::update("imagewithmarkers", $content, "id=".$locationId);
		return true;
	}
	public function getLocationByNumber( $number ){
		return $rs =  DB::query("SELECT * FROM imagewithmarkers WHERE status=1 AND order_number=?",$number);		
	}
	public function getLocationByClassName( $class_name ){
		return DB::query("SELECT * FROM imagewithmarkers WHERE status = 1 AND className = ? GROUP BY order_number ORDER BY order_number",$class_name);
	}


}
?>