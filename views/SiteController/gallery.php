<?php
/**
 * @var models\Image[] $gallery
 */
?>
<div class="container col-lg-10 col-lg-offset-1 col-md-10 col-md-offset-1  col-sm-10 col-sm-offset-1 col-xs-12 col-xs-offset-0">
    <h1>Your Gallery</h1>
    <a href="/site/upload/">Upload new image</a>
    <a href="/user/logout/" id="gallery-logout">Logout</a>
    <hr>
    <p id="gallery-is-empty" class="<?=(empty($gallery))?'':'hidden';?>">Your Gallery is empty. Start fill your Gallery with images right now and create amazing image collection!</p>
<?php foreach ($gallery as $img) :?>
    <div class="image-container col-lg-4 col-md-6 col-sm-6 col-xs-12">
        <div class="internal-container">
            <p class="image-date">Added to gallery: <?=date('d.m.Y', $img->date)?></p>
            <form action="/site/delete" method="POST" class="image-delete-frm">
                <input type="hidden" name="imageId" value="<?=$img->id?>" class="image-form-imageId">
                <input type="submit" value="Delete">
            </form>
        </div>
        <img class="preview-img col-lg-10 col-lg-offset-1 col-md-10 col-md-offset-1 col-sm-10 col-sm-offset-1 col-xs-10 col-xs-offset-1" src="<?= '/' . $img->path;?>">
        <hr>
        <p class="image-descr"><?= $img->getDescription(); ?></p>
    </div>
<?php endforeach;?>
</div>