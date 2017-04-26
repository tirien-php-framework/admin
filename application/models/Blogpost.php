<?php

require_once(dirname(__FILE__).'/'.'Query_Builder.php'); 

class Model_BlogPost extends Query_Builder
{
    public $table = 'blog_posts';

    public function getAllVisible()
    {
		return DB::query( "SELECT * FROM $this->table WHERE status=1 and visible=1 ORDER BY created_at DESC");	
    }
}
