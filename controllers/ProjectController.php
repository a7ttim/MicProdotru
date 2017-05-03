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
use yii\data\Pagination;

class ProjectController extends Controller
{
    public function actionList()
    {
        $model = new Project();
        $projects = Project::find()->where(['status' => 1, 'pm_id' => Yii::$app->user->identity->user_id]);
        $pagination = new Pagination([
            'defaultPageSize' => 1,
            'totalCount' => $projects->count(),
        ]);

        $projects = $projects->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();

        return $this->render('list', [
            'model' => $model,
            'projects' => $projects,
            'pagination' => $pagination,
        ]);
    }

    public function actionInfo()    {
        $model = new Project();
        $project = Project::findOne(['project_id' => Yii::$app->request->get('project_id')]);

        return $this->render('info', [
            'model' => $model,
            'project' => $project,
        ]);
    }

    public function actionIndex(){
        return $this->actionList();
    }
}