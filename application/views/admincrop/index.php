<link rel="stylesheet" href="scripts/admin/jcrop/css/Jcrop.min.css" media="screen" charset="utf-8">
<script src="scripts/admin/jcrop/js/Jcrop.min.js"></script>

<style>
    div.jcrop-active {
        width: auto !important;
        height: auto !important;
    }
</style>

<div class="admin-header">
    <h1>Crop image</h1>
</div>

<div class="admin-content">

    <?php Alert::show() ?>
    <form action="admincrop/save" method="post">

        <div class="gallery-wrap"> 
            <ul class="image-list cf" >
                <li class="items-order" data-id="{{$image->id}}">
                    <img id="crop" src="<?php echo $this->view->imageSrc ?>" />
                    <div class="inputNote" style="text-align:center; margin:10px auto;">*Select area first and click CROP</div>
                </li>
            </ul>
        </div>  

        <div class="action-wrap">
            <input type="submit" value="Crop" class="save-item">
            <a class="button remove-item" href="javascript:history.back()">Back</a>
        </div>

        <input type="hidden" name="image_src" value="<?php echo $this->view->imageSrc ?>" />
        <input type="hidden" name="redirect_uri" value="<?php echo $_GET['redirect_uri'] ?>" />
        <input type="hidden" id="coords" name="coords" />
        
        <?php $image = getimagesize("public/".$this->view->imageSrc); ?>

        <script>
            $(function(){

                var imageCropped = function(c){
                    $("#coords").val(JSON.stringify(c));
                }

                $('#crop').Jcrop({
                    boxWidth: 174,
                    boxHeight: 85,
                    onSelect: imageCropped,
                    <?php echo "aspectRatio: {$image[0]}/{$image[1]}";?>
                });

            });
        </script>

    </form>
</div>