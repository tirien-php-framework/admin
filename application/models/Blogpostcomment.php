<?php

require_once(dirname(__FILE__).'/'.'Query_Builder.php'); 

class Model_BlogPostComment extends Query_Builder
{
    public $table = 'blog_post_comments';	
}
