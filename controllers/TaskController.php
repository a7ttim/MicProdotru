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
use app\models\Project;
use app\models\User;
use app\models\Department;
use yii\data\Pagination;
use yii\data\ActiveDataProvider;

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

    public function actionSogl()
    {
        $model = new Task();
        $dataProvider = new ActiveDataProvider([
            'query' => Task::find()->where(['user_id' => Yii::$app->user->identity->user_id ,'status_id' => 3]),
            'pagination' => [
                'pageSize' => 2,
            ],
        ]);

        return $this->render('sogl', [
            'model' => $model,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionSoglinfo()    {
        $model = new Task();
        $tasks = Task::findOne($_GET['task_id']);
        $previous_task=Task::findOne($tasks->previous_task_id);

        return $this->render('soglinfo', [
            'model' => $model,
            'tasks' => $tasks,
            'previous_task'=>$previous_task,
            'post' => Yii::$app->request->post('ok'),
        ]);
    }

    public function actionIndex(){
        return $this->actionSogl();
    }
}