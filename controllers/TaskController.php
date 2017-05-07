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
use app\models\Task;
use yii\data\Pagination;

class TaskController extends Controller
{
	public function beforeAction($action)
	{
		if (parent::beforeAction($action)) {
			if (!\Yii::$app->user->can('pe')) {
				throw new \yii\web\ForbiddenHttpException('Доступ закрыт.');
			}
			return true;
		} else {
			return false;
		}
	}
	
    public function actionList()
    {
        $model = new Task();
        $tasks = Task::find()->where(['user_id' => Yii::$app->user->identity->user_id]);
        $pagination = new Pagination([
            'defaultPageSize' => 10,
            'totalCount' => $tasks->count(),
        ]);

        $tasks = $tasks->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();

        return $this->render('list', [
            'model' => $model,
            'tasks' => $tasks,
            'pagination' => $pagination,
        ]);
    }

    public function actionInfo()    {
        
    }

    public function actionIndex(){
        return $this->actionList();
    }
}