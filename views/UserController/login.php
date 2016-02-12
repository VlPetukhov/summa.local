<?php
/**
 * Login page
 */

use app\App;

$this->title = "Photo album";
/** @var models\User $user */

?>
<div class="container col-sm-8 col-sm-offset-2">
    <h1>Photo album</h1>
    <hr>
    <h3>Login or <a href="/user/create">SignUp</a></h3>
    <form action="/user/login" method="POST">
        <div class="row">
            <div class="form-group<?= ($user->hasErrors('email')) ? ' has-error' : '';?>">
                <label class="control-label" for="user-email">Email:</label>
                <input type="email" class="form-control" name="User[email]" id="user-email" value="<?=$user->email;?>">
                <?php if($user->hasErrors('email')): ?>
                    <?php foreach($user->getErrorMsg('email') as $msg): ?>
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
                <input type="submit" name="submit" id="user-submit" value="Login     ">
            </div>
        </div>
    </form>
</div>