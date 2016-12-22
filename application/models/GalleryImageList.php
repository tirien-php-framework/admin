<?php

Class Model_GalleryImageList
{
    private $items = array();
    private static $instance;
    private function __construct() {
        $rs = db::query('select * from gallery_images order by order_number');
        foreach($rs as $row){
            $this->items[] = new ProjectGalleryImage($row);
        }
    }
    /**
     *
     * @return Model_GalleryImageList
     */
    public static function getInstance(){
        if  (!isset(self::$instance)){
            self::$instance = new Model_GalleryImageList();
        }
        return self::$instance;
    }
    /**
     *
     * @return ProjectGalleryImage[]
     */
    public function get(){
        return $this->items;
    }
    public function add($item){
        $this->items[] = $item;
    }
    public function remove($i){
        if (isset($this->items[$i])){
            unset($this->items[$i]);
        }
    }

}