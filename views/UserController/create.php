<?php
/**
 * @var app\View $this
 * @var models\User $user
 */
$this->title = "Photo album: User creation.";
?>
<div class="container col-sm-8 col-sm-offset-2">
<h1>New user creation</h1>
<hr>
<form action="" method="POST">
    <div class="row">
        <div class="form-group<?= ($user->hasErrors('email')) ? ' has-error' : '';?>">
            <label class="control-label" for="user-email">User email:</label>
            <input type="email" class="form-control" name="User[email]" id="user-email" value="<?=$user->email;?>">
<?php if($user->hasErrors('email')): ?>
<?php foreach($user->getErrorMsg('email') as $msg): ?>
            <span class="alert-danger"><?=$msg;?></span>
<?php endforeach;?>
<?php endif;?>
        </div>
        <div class="form-group<?= ($user->hasErrors('name')) ? ' has-error' : '';?>">
            <label class="control-label" for="user-name">User name:</label>
            <input type="text" class="form-control" name="User[name]" id="user-name" value="<?=$user->name;?>">
<?php if($user->hasErrors('name')): ?>
<?php foreach($user->getErrorMsg('name') as $msg): ?>
            <span class="alert-danger"><?=$msg;?></span>
<?php endforeach;?>
<?php endif;?>
        </div>
        <div class="form-group<?= ($user->hasErrors('surname')) ? ' has-error' : '';?>">
            <label class="control-label" for="user-surname">User surname:</label>
            <input type="text" class="form-control" name="User[surname]" id="user-surname" value="<?=$user->surname;?>">
<?php if($user->hasErrors('surname')): ?>
<?php foreach($user->getErrorMsg('surname') as $msg): ?>
            <span class="alert-danger"><?=$msg;?></span>
<?php endforeach;?>
<?php endif;?>
        </div>
        <div class="form-group<?= ($user->hasErrors('password')) ? ' has-error' : '';?>">
            <label class="control-label" for="user-password">Password:</label>
            <input type="password" class="form-control" name="User[password]" id="user-password">
<?php if($user->hasErrors('password')): ?>
<?php foreach($user->getErrorMsg('password') as $msg): ?>
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