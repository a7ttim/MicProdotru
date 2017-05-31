<?php
/**
 * Created by PhpStorm.
 * User: A7ttim
 * Date: 01.05.2017
 * Time: 17:04
 */

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;


class AuthController extends Controller
{
    /**
     * Login index.
     *
     * @return Response|string
     */

    public function actionIndex(){
        return $this->actionLogin();
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
		$this->layout = '@app/views/layouts/auth.php';
		
        if (Yii::$app->user->can('pm')) {
            return $this->redirect('./project/list');
        }

        if (Yii::$app->user->can('pe')) {
            return $this->redirect('./task/sogl');
        }
		
		if (Yii::$app->user->can('dh')) {
            return $this->redirect('./resource/list');
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

}