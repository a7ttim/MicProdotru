<?php
/**
 * Created by PhpStorm.
 * User: A7ttim
 * Date: 03.05.2017
 * Time: 13:21
 */

namespace app\controllers;

use app\models\Project;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

class ProjectController extends Controller
{
    public function actionList()
    {
        $model = new Project();
        $projects = Project::find()->all();
        return $this->render('list', [
            'model' => $model,
            'projects' => $projects,
        ]);
    }

    public function actionIndex(){
        return $this->actionList();
    }
}