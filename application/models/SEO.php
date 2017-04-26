<?php 
Class Model_SEO{
	
	public function getAll(){
		return DB::query("SELECT * FROM page_meta ORDER BY uri");	
	}

	public function get($uri){
		return DB::query("SELECT * FROM page_meta WHERE uri=?", $uri);
	}

	public function find($id){
		return DB::query("SELECT * FROM page_meta WHERE id=?", $id ,true);
	}

	public function update( $content, $id ){
		DB::update("page_meta", $content, "id=".$id);
		return true;
	}
}
?>