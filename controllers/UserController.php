<?php
/**
 * User controller
 */

namespace controllers;


use app\App;
use app\BaseController;
use models\User;

class UserController extends BaseController{

    public function actionCreate()
    {
        $user = new User();

        $user->scenario = 'create';

        if (isset($_POST['User']) &&
            is_array($_POST['User']) &&
            $user->load($_POST['User']) &&
            $user->save()
        ) {
            $this->redirect(['site/index']);;
        }

        $this->render('create', ['user' => $user]);
    }

    public function actionLogin()
    {
        if ( !App::instance()->isGuest() ) {

          $this->redirect('/site/index/');
        }

        $user = new User();

        if ( isset($_POST['User']) && $user->load($_POST['User']) && $user->login() ) {

            $_SESSION['loggedUserId'] = App::instance()->user->id;

            $this->redirect('/site/index/');
        }

        $this->render('login', ['user' => $user]);
    }

    public function actionLogout()
    {
        if ( !App::instance()->isGuest() ) {

            App::instance()->logoutUser();
        }

        $this->redirect('/site/index/');
    }
} 