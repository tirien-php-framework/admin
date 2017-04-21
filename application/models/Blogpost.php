<?php

require_once(dirname(__FILE__).'/'.'Query_Builder.php'); 

class Model_BlogPost extends Query_Builder
{
    public $table = 'blog_posts';
}
