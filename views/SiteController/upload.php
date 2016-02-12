<?php
/**
 * @var app\View $this
 * @var models\Image $image
 */
use app\App;

$this->title = "Gallery: Add new image.";
?>
<div class="container col-sm-8 col-sm-offset-2">
<h1><?=App::instance()->getUser()->name;?>'s Gallery: add new image.</h1>
<hr>
<form action="" method="POST" enctype="multipart/form-data">
    <div class="row">
        <div class="form-group<?= ($image->hasErrors('imageFile')) ? ' has-error' : '';?>">
            <label class="control-label" for="image-file">File:</label>
            <input type="file" class="form-control" name="Image[imageFile]" id="image-file" accept="image/*">
<?php if($image->hasErrors('imageFile')): ?>
<?php foreach($image->getErrorMsg('imageFile') as $msg): ?>
            <span class="alert-danger"><?=$msg;?></span>
<?php endforeach;?>
<?php endif;?>
        </div>
    <div class="row">
        <div class="form-group<?= ($image->hasErrors('description')) ? ' has-error' : '';?>">
            <label class="control-label" for="image-description">File:</label>
            <textarea class="form-control" name="Image[description]" id="image-description"><?=$image->description;?></textarea>
<?php if($image->hasErrors('description')): ?>
<?php foreach($image->getErrorMsg('description') as $msg): ?>
            <span class="alert-danger"><?=$msg;?></span>
<?php endforeach;?>
<?php endif;?>
        </div>
        <div class="form-group">
            <input type="submit" name="submit" id="user-submit" value="Save ">
        </div>
    </div>
</form>
<hr>
<a href="/site/index/">Return to main page</a>
</div>