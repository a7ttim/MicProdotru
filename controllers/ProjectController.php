<?php
/**
 * Created by PhpStorm.
 * User: A7ttim
 * Date: 03.05.2017
 * Time: 13:21
 */

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\Project;
use yii\data\Pagination;

class ProjectController extends Controller
{
	public function beforeAction($action)
	{
		if (parent::beforeAction($action)) {
			if (!\Yii::$app->user->can('pm')) {
				throw new \yii\web\ForbiddenHttpException('Доступ закрыт.');
			}
			return true;
		} else {
			return false;
		}
	}
	
    public function actionList()
    {
        $model = new Project();
        $projects = Project::find()->where(['pm_id' => Yii::$app->user->identity->user_id]);
        $pagination = new Pagination([
            'defaultPageSize' => 10,
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