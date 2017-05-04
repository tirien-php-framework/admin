<?php

Class Model_GalleryImage 
{
    private $id , $title , $text , $source , $phone , $thumb , $large , $parentId , $orderNumber , $visible, $thumbGrey, $floorplan, $pdf, $projectLink;

    private static $tableName = 'gallery_images';

    function __construct($values = null) {
        if (isset($values)) {
            $this->assignValues($values);
        }
    }

    private function assignValues($values) {
        $this->id = $values['id'];
        $this->title = $values['title'];
        $this->text = $values['text'];
        $this->source = $values['source'];
        $this->phone = $values['phone'];
        $this->thumb = $values['thumb'];
        $this->large = $values['large'];
        $this->parentId = $values['gallery_id'];
        $this->orderNumber = $values['order_number'];
        $this->visible = $values['visible'];
        $this->thumbGrey = $values['thumb_gray'];
        $this->floorplan = $values['floorplan'];
        $this->pdf = $values['pdf'];
        $this->blur = $values['blur'];
        $this->projectLink = $values['project_link'];
    }

    public function load($id) {
        $rs = db::query('select * from ' . self::$tableName . ' where id=?', $id);
        if (count($rs)) {
            $this->assignValues($rs[0]);
            return $this;
        }
        return false;
    }

    public function save() {
        $data = array(
                'title' => $this->title,
                'text' => $this->text,
                'source' => $this->source,
                'phone' => $this->phone,
                'thumb' => $this->thumb,
                'large' => $this->large,
                'gallery_id' => $this->parentId,
                'order_number' => $this->orderNumber,
                'visible' => $this->visible,
                'thumb_gray' => $this->thumbGrey,
                'floorplan' => $this->floorplan,
                'pdf' => $this->pdf,
                'blur' => $this->blur,
                'project_link' => $this->projectLink
                );
        if (isset($this->id)) {
            db::update(self::$tableName, $data, array('id' => $this->id));
        } else {
            $this->id = db::insert(self::$tableName, $data);
        }
        return $this;
    }

    public function remove() {
        if (isset($this->id)){
            if (is_file("public/".$this->source)) {
                unlink("public/".$this->source);
            }
            if (is_file("public/".$this->phone)) {
                unlink("public/".$this->phone);                
            }
            if (is_file("public/".$this->thumb)) {
                unlink("public/".$this->thumb);                
            }
            if (is_file("public/".$this->thumbGrey)) {             
                unlink("public/".$this->thumbGrey);
            }
            return db::delete(self::$tableName, array('id'=>$this->id));
        }
        return true;
    }

    public function getId(){
        return $this->id;
    }
    /**
     *
     * @return Model_GalleryImage     */
    public function setId($id){
        $this->id = $id;
        return $this;
    }

    public function getTitle(){
        return $this->title;

    }
    /**
     *
     * @return Model_GalleryImage     */
    public function setTitle($title){
        $this->title = $title;
        return $this;

    }
    public function getText(){
        return $this->text;

    }
    /**
     *
     * @return Model_GalleryImage     */
    public function setText($text){
        $this->text = $text;
        return $this;

    }
    public function getSource(){
        return $this->source;

    }
    /**
     *
     * @return Model_GalleryImage     */
    public function setSource($source){
        $this->source = $source;
        return $this;

    }
    public function getPhone(){
        return $this->phone;

    }
    /**
     *
     * @return Model_GalleryImage     */
    public function setPhone($phone){
        $this->phone = $phone;
        return $this;

    }

    public function getThumb(){
        return $this->thumb;

    }
    /**
     *
     * @return Model_GalleryImage     */
    public function setThumb($thumb){
        $this->thumb = $thumb;
        return $this;

    }

    public function getLarge(){
        return $this->large;

    }
    /**
     *
     * @return Model_GalleryImage     */
    public function setLarge($large){
        $this->large = $large;
        return $this;

    }




    public function getParentId(){
        return $this->parentId;

    }
    /**
     *
     * @return Model_GalleryImage     */
    public function setParentId($parentId){
        $this->parentId = $parentId;
        return $this;

    }
    public function getOrderNumber(){
        return $this->orderNumber;

    }
    /**
     *
     * @return Model_GalleryImage     */
    public function setOrderNumber($orderNumber){
        $this->orderNumber = $orderNumber;
        return $this;

    }
    public function getVisible(){
        return $this->visible;

    }
    /**
     *
     * @return Model_GalleryImage     */
    public function setVisible($visible){
        $this->visible = $visible;
        return $this;

    }
    public function getThumbGrey(){
        return $this->thumbGrey;

    }
    /**
     *
     * @return Model_GalleryImage     */
    public function setThumbGrey($thumbGrey){
        $this->thumbGrey = $thumbGrey;
        return $this;

    }


    public function getFloorplan(){
        return $this->floorplan;

    }
    /**
     *
     * @return Model_GalleryImage     */
    public function setFloorplan($floorplan){
        $this->floorplan = $floorplan;
        return $this;

    }

    public function getPdf(){
        return $this->pdf;

    }
    /**
     *
     * @return Model_GalleryImage     */
    public function setPdf($pdf){
        $this->pdf = $pdf;
        return $this;

    }

    public function getBlur(){
        return $this->blur;

    }
    /**
     *
     * @return Model_GalleryImage     */
    public function setBlur($blur){
        $this->blur = $blur;
        return $this;

    }
    public function getProjectlink(){
        return $this->projectLink;

    }
    /**
     *
     * @return Model_GalleryImage     */
    public function setProjectLink($projectLink){
        $this->projectLink = $projectLink;
        return $this;

    }

}