<?php

require(dirname(__FILE__).'/'.'Query_Builder.php'); 

Class Model_Page extends Query_Builder
{	
	public function getAll(){
		return DB::query("SELECT * FROM page WHERE status=1");	
	}

	public function getPagesTitleById( $page_id){
		$rs = DB::query("SELECT * FROM page WHERE status=1 AND id=?",$page_id,true);		
		return $rs['title'];
	}

	public function getById( $page_id ){
		return DB::query("SELECT * FROM page WHERE status=1 AND id=?", $page_id, true);	
	}

	public function getElements( $page_id ){
		return DB::query("SELECT * FROM page_element WHERE status=1 AND page_id=?", $page_id);	
	}

	public function getElement( $element_id ){
		return DB::query("SELECT * FROM page_element WHERE status=1 AND id=?", $element_id, true);	
	}

	public function getElementContent( $element_id ){
		$element = $this->getElement($element_id);
		$p = ml::p();
		// return $element['type_id']==2 ? nl2br($element['content']) : $element['content'];	
		return nl2br( empty($p) ? $element['content'] : $element['content_'.trim($p,"/")] );	

	}

	public function updateElements( $elements ){
		$p = ml::p();
		foreach ($elements as $key => $content) {
			$set = empty($p) ? array("content"=>$content) : array('content_'.trim($p,"/")=>$content);
			DB::update("page_element", $set, "id=".$key);	
		}

		return true;
	}

	public function getMeta( $uri ){
		return DB::query("SELECT * FROM page_meta WHERE IFNULL(uri,'') = ?", $uri, true);	
	}

}
?>