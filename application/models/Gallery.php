<?php

Class Model_Gallery 
{
    function __construct($values = null) {
        if (isset($values)) {
            $this->assignValues($values);
        }
    }

    public function getAllGalleries(){
        return db::query('SELECT * FROM galleries ORDER BY order_number');
    }

    public function getVisibleGalleries(){
        return db::query('SELECT * FROM galleries WHERE visible=1 ORDER BY order_number');
    }

    public function getGallery($id){
        return db::query('SELECT * FROM galleries WHERE id=?', $id, true);
    }

    public function getFirstGalleryId(){
        $rs = db::query('SELECT * FROM galleries WHERE visible=1 ORDER BY order_number LIMIT 1', array(), true);
        return empty($rs['id']) ? null : $rs['id'];
    }

    public function getGalleryImages($id){ 
        return db::query('SELECT * FROM gallery_images WHERE gallery_id = ? ORDER BY order_number', $id);
    }

    public function getAllGalleryImages(){ 
        return db::query('SELECT * FROM gallery_images ORDER BY gallery_id,order_number');
    }

    public function addGallery( $event_id = false ) {
        $data = array(
            "title" => 'Gallery',
            "event_id" => $event_id
            );
        DB::insert( "galleries", $data);    
    }

    public function getEventId( $gallery_id){
        $rs = DB::query("SELECT event_id FROM galleries WHERE visible=1 AND id=?", $gallery_id, true);
        return $rs['event_id'];
    }

    public function saveGallery($id, $data) {

        return DB::update( "galleries", $data, "id=".$id );
        
    }

    public function removeGallery($id) {

        $gallery = $this->getGallery($id);
        $images = $this->getGalleryImages($id);

        foreach ($images as $image) {
            $this->removeImage($image['id']);
        }

        unlink('public'.DIRECTORY_SEPARATOR.$gallery['thumb']);
        unlink('public'.DIRECTORY_SEPARATOR.$gallery['thumb_hover']);


        return db::delete('galleries', array('id'=>$id));
        
    }

    public function getImage($id) {

        return db::query('SELECT * FROM gallery_images WHERE id=?', $id, true);
        
    }

    public function removeImage($id) {

        $image = $this->getImage($id);

        unlink('public'.DIRECTORY_SEPARATOR.$image['source']);
        unlink('public'.DIRECTORY_SEPARATOR.$image['thumb']);
        unlink('public'.DIRECTORY_SEPARATOR.$image['thumb_gray']);
        return db::delete('gallery_images', array('id'=>$id));
        
    }

    public function getGalleries($event_id, $use_as_project=null){
        $use_as_project = $use_as_project ? "use_as_project =".$use_as_project." AND " : '';
        return db::query('SELECT * FROM galleries WHERE '.$use_as_project.'event_id=?', $event_id, true);
    }

    
}
