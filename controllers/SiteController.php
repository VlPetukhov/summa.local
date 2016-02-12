<?php
/**
 * Created by PhpStorm.
 * User: Vladimir
 * Date: 09.02.2016
 * Time: 23:35
 */

namespace controllers;


use app\App;
use app\BaseController;
use models\Image;

class SiteController extends BaseController
{

    public function actionIndex()
    {
        if (App::instance()->isGuest()) {

            $this->redirect('/user/login/');
        }

        $gallery = Image::findAllByProp('uid', App::instance()->getUser()->getId());

        $this->render('gallery', ['gallery' => $gallery]);
    }

    public function actionUpload()
    {
        $image = new Image();

        $image->scenario = 'create';

        if (isset($_FILES['Image']['error']['imageFile']) && $_FILES['Image']['error']['imageFile'] == 0) {
            $image->imageFile = 'Image';
        }

        if (isset($_POST['Image']) &&
            is_array($_POST['Image']) &&
            $image->load($_POST['Image']) &&
            $image->save()
        ) {
            $this->redirect('/site/index/');
        }

        $this->render('upload', ['image' => $image]);
    }

    public function actionDelete()
    {
        if ( !isset($_POST['imageId']) ) {
            App::instance()->show404();
            exit;
        }

        /** @var \models\Image $model */
        $model = Image::findByID( (int)$_POST['imageId'] );

        if ( !$model || $model->uid != App::instance()->getUser()->getId()) {
            App::instance()->show404();
            exit;
        }


        if ( $model->delete()) {
            $response['error'] = false;
        } else {
            $response = json_encode([
                'error' => true,
            ]);
        }

        if ( isset ($_SERVER['HTTP_X_REQUESTED_WITH']) && 'XMLHttpRequest' === $_SERVER['HTTP_X_REQUESTED_WITH'] ) {
            $response['totalCount'] = Image::countByProp('uid', App::instance()->getUser()->getId());
            echo json_encode($response);
        } else {
            $this->redirect('/site/index/');echo $response;
        }
    }
}