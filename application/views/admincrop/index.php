<link rel="stylesheet" href="scripts/admin/jcrop/css/jquery.Jcrop.min.css" media="screen" charset="utf-8">
<script src="scripts/admin/jcrop/jquery.Jcrop.min.js"></script>

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

        <script>
            $(function(){

                var imageCropped = function(c){
                    $("#coords").val(JSON.stringify(c));
                }

                $('#crop').Jcrop({
                    boxWidth: 800,
                    boxHeight: 600,
                    onSelect: imageCropped,
                    <?php echo !empty($_GET['width']) && !empty($_GET['width']) ? "aspectRatio: {$_GET['width']}/{$_GET['height']} " : "" ?>
                });

            });
        </script>

    </form>
</div>