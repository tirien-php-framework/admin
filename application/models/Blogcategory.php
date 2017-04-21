<?php

require_once(dirname(__FILE__).'/'.'Query_Builder.php'); 

class Model_BlogCategory extends Query_Builder
{
    public $table = 'blog_categories';
	
	public function getBlogPosts($blog_category_id)
	{
		$this->Location = new Model_Blogpost();
		return $this->Location->where('blog_category_id', $blog_category_id);
	}    
}
